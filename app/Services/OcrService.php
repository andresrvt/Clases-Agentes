<?php

namespace App\Services;

use App\Models\Document;
use App\Models\IaConfiguration;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class OcrService
{
    private OllamaService $ollamaService;

    public function __construct(OllamaService $ollamaService)
    {
        $this->ollamaService = $ollamaService;
    }

    public function getConfiguration(): ?IaConfiguration
    {
        $config = IaConfiguration::byProcess('ocr')->active()->first();
        Log::info('[OcrService] getConfiguration: ' . ($config ? 'found' : 'not found'));
        if ($config) {
            Log::info('[OcrService] Config model: ' . $config->model . ', prompt: ' . substr($config->prompt, 0, 50) . '...');
        }
        return $config;
    }

    public function process(Document $document): array
    {
        Log::info('[OcrService] Processing document ID: ' . $document->id);
        
        $config = $this->getConfiguration();
        if (!$config) {
            Log::error('[OcrService] No OCR configuration found or inactive');
            return ['success' => false, 'message' => 'OCR configuration not found or inactive'];
        }

        if ($document->ocr_status === 'completed') {
            Log::info('[OcrService] Document already processed');
            return ['success' => true, 'response' => 'Already processed', 'already_completed' => true];
        }

        Log::info('[OcrService] Updating status to processing');
        $document->update(['ocr_status' => 'processing']);

        $storagePath = $this->getFullPath($document->storage_path);
        Log::info('[OcrService] Storage path: ' . $storagePath);
        
        if (!file_exists($storagePath)) {
            Log::error('[OcrService] File not found: ' . $storagePath);
            $document->update(['ocr_status' => 'failed']);
            return ['success' => false, 'message' => 'Document file not found: ' . $storagePath];
        }

        Log::info('[OcrService] Extracting text from PDF');
        $textContent = $this->extractTextFromPdf($storagePath);
        Log::info('[OcrService] Extracted ' . strlen($textContent) . ' characters');

        if (empty(trim($textContent))) {
            Log::warning('[OcrService] No text extracted from PDF');
            $document->update(['ocr_status' => 'failed']);
            return ['success' => false, 'message' => 'No text could be extracted from PDF. The document may be scanned/image-based.'];
        }

        $prompt = $config->prompt . "\n\n[Document text content]:\n" . $textContent;
        Log::info('[OcrService] Calling Ollama with model: ' . $config->model);
        
        $result = $this->ollamaService->generate($config->model, $prompt, 180);

        Log::info('[OcrService] Ollama result success: ' . ($result['success'] ? 'YES' : 'NO'));
        if (!$result['success']) {
            Log::error('[OcrService] Ollama error: ' . ($result['message'] ?? 'unknown'));
        }

        if ($result['success']) {
            $document->update([
                'ocr_status' => 'completed',
                'ocr_result' => $result['response'],
                'ocr_completed_at' => now()
            ]);
            Log::info('[OcrService] OCR completed successfully');
            return ['success' => true, 'response' => $result['response']];
        }

        Log::error('[OcrService] OCR failed');
        $document->update(['ocr_status' => 'failed']);
        return ['success' => false, 'message' => $result['message'] ?? 'OCR processing failed'];
    }

    private function getFullPath(string $storagePath): string
    {
        $basePath = config('filesystems.disks.local.root', storage_path('app/private'));
        $fullPath = $basePath . '/' . $storagePath;
        Log::debug('[OcrService] getFullPath: ' . $fullPath);
        return $fullPath;
    }

    private function extractTextFromPdf(string $path): string
    {
        Log::debug('[OcrService] extractTextFromPdf: ' . $path);
        
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($path);
            $text = $pdf->getText();
            
            if (empty(trim($text))) {
                $images = $pdf->getObjectsByType('XObject', 'Image');
                if (count($images) > 0) {
                    Log::info('[OcrService] PDF has images but no text (scanned document)');
                    return '[PDF contains images but no extractable text. This appears to be a scanned document.]';
                }
                Log::warning('[OcrService] PDF is empty');
                return '';
            }
            
            return $this->cleanText($text);
        } catch (\Exception $e) {
            Log::error('[OcrService] PDF extraction error: ' . $e->getMessage());
            return '';
        }
    }

    private function cleanText(string $text): string
    {
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/^\s*[\r\n]+/m', '', $text);
        $text = trim($text);
        return $text;
    }
}