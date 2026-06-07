<?php

namespace App\Services;

use App\Models\Document;
use App\Models\IaConfiguration;

class CvAnalysisService
{
    private OllamaService $ollamaService;

    public function __construct(OllamaService $ollamaService)
    {
        $this->ollamaService = $ollamaService;
    }

    public function getConfiguration(): ?IaConfiguration
    {
        return IaConfiguration::byProcess('cv_analysis')->active()->first();
    }

    public function analyze(Document $document): array
    {
        $config = $this->getConfiguration();
        if (!$config) {
            return ['success' => false, 'message' => 'CV Analysis configuration not found or inactive'];
        }

        if (!$document->ocr_result) {
            return ['success' => false, 'message' => 'No OCR result available. Run OCR first.'];
        }

        $document->update(['cv_analysis_status' => 'processing']);

        $prompt = $config->prompt . "\n\nDocument content:\n" . $document->ocr_result;

        $result = $this->ollamaService->generate($config->model, $prompt, 120);

        if ($result['success']) {
            $parsed = $this->parseAnalysisResponse($result['response']);

            $document->update([
                'cv_analysis_status' => 'completed',
                'cv_is_cv' => $parsed['is_cv'],
                'cv_quality_score' => $parsed['quality_score'],
                'cv_analysis_completed_at' => now()
            ]);

            return [
                'success' => true,
                'is_cv' => $parsed['is_cv'],
                'quality_score' => $parsed['quality_score'],
                'reasoning' => $parsed['reasoning']
            ];
        }

        $document->update(['cv_analysis_status' => 'failed']);
        return ['success' => false, 'message' => $result['message'] ?? 'CV Analysis failed'];
    }

    private function parseAnalysisResponse(string $response): array
    {
        if (preg_match('/\{.*\}/s', $response, $matches)) {
            $json = json_decode($matches[0], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return [
                    'is_cv' => $json['is_cv'] ?? false,
                    'quality_score' => $json['quality_score'] ?? 0,
                    'reasoning' => $json['reasoning'] ?? ''
                ];
            }
        }

        $isCv = stripos($response, '"is_cv":true') !== false || stripos($response, '"is_cv" : true') !== false;
        $score = 0;
        if (preg_match('/"quality_score"\s*:\s*(\d+)/', $response, $m)) {
            $score = (int)$m[1];
        }

        return [
            'is_cv' => $isCv,
            'quality_score' => $score,
            'reasoning' => $response
        ];
    }
}