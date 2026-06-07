<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\ConnectionException;

class OllamaService
{
    private string $baseUrl;
    private bool $connected = false;

    public function __construct(?string $baseUrl = null)
    {
        $this->baseUrl = $baseUrl ?? env('OLLAMA_HOST', 'http://localhost:11434');
        
        Log::info('[OllamaService] Initialized with baseUrl: ' . $this->baseUrl);
    }

    public function connect(): bool
    {
        try {
            Log::info('[OllamaService] Attempting connect to: ' . $this->baseUrl);
            $response = Http::timeout(5)->get($this->baseUrl . '/api/tags');
            $this->connected = $response->successful();
            Log::info('[OllamaService] Connect result: ' . ($this->connected ? 'SUCCESS' : 'FAILED'));
            return $this->connected;
        } catch (ConnectionException $e) {
            Log::error('[OllamaService] Connection exception: ' . $e->getMessage());
            $this->connected = false;
            return false;
        }
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function listLocalModels(): array
    {
        try {
            Log::info('[OllamaService] Listing models from: ' . $this->baseUrl);
            $response = Http::timeout(10)->get($this->baseUrl . '/api/tags');
            if ($response->successful()) {
                $data = $response->json();
                $models = $data['models'] ?? [];
                Log::info('[OllamaService] Found ' . count($models) . ' models');
                return $models;
            }
            Log::warning('[OllamaService] List models failed: ' . $response->body());
            return [];
        } catch (ConnectionException $e) {
            Log::error('[OllamaService] List models exception: ' . $e->getMessage());
            return [];
        }
    }

    public function pullModel(string $modelName): array
    {
        try {
            Log::info('[OllamaService] Pulling model: ' . $modelName);
            $response = Http::timeout(300)->post($this->baseUrl . '/api/pull', [
                'name' => $modelName,
                'stream' => false
            ]);
            $success = $response->successful();
            Log::info('[OllamaService] Pull result: ' . ($success ? 'SUCCESS' : 'FAILED'));
            return ['success' => $success, 'message' => $success ? 'Model pulled successfully' : $response->body()];
        } catch (ConnectionException $e) {
            Log::error('[OllamaService] Pull exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function deleteModel(string $modelName): array
    {
        try {
            Log::info('[OllamaService] Deleting model: ' . $modelName);
            $response = Http::timeout(30)->delete($this->baseUrl . '/api/delete/' . $modelName);
            $success = $response->successful();
            Log::info('[OllamaService] Delete result: ' . ($success ? 'SUCCESS' : 'FAILED'));
            return ['success' => $success, 'message' => $success ? 'Model deleted successfully' : $response->body()];
        } catch (ConnectionException $e) {
            Log::error('[OllamaService] Delete exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }

    public function generate(string $modelName, string $prompt, int $timeout = 120): array
    {
        Log::info('[OllamaService] Generate request for model: ' . $modelName . ', timeout: ' . $timeout . 's');
        Log::debug('[OllamaService] Prompt length: ' . strlen($prompt) . ' chars');
        
        try {
            $payload = [
                'model' => $modelName,
                'prompt' => $prompt,
                'stream' => false
            ];
            
            Log::debug('[OllamaService] Sending request to: ' . $this->baseUrl . '/api/generate');
            
            $response = Http::timeout($timeout)->post($this->baseUrl . '/api/generate', $payload);
            
            Log::info('[OllamaService] Response status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                $responseText = $data['response'] ?? '';
                Log::info('[OllamaService] Generate success, response length: ' . strlen($responseText) . ' chars');
                return ['success' => true, 'response' => $responseText];
            }
            
            $body = $response->body();
            Log::warning('[OllamaService] Generate failed with status ' . $response->status() . ': ' . $body);
            return ['success' => false, 'message' => $body];
            
        } catch (ConnectionException $e) {
            Log::error('[OllamaService] Generate connection exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()];
        }
    }
    
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }
}