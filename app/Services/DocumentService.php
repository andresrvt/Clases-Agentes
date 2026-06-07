<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    private const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB
    private const ALLOWED_MIME_TYPES = ['application/pdf'];

    public function upload(UploadedFile $file): array
    {
        if (!$this->validateFile($file)) {
            return ['success' => false, 'message' => 'Invalid file. Must be PDF and under 10MB.'];
        }

        $document = $this->store($file);
        return ['success' => true, 'document' => $document];
    }

    private function validateFile(UploadedFile $file): bool
    {
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            return false;
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file->getRealPath());

        return in_array($mimeType, self::ALLOWED_MIME_TYPES);
    }

    private function store(UploadedFile $file): Document
    {
        $filename = $this->generateUniqueFilename($file->getClientOriginalName());
        $path = $file->storeAs('documents', $filename, 'local');

        return Document::create([
            'original_filename' => $file->getClientOriginalName(),
            'storage_path' => $path,
            'file_size' => $file->getSize(),
            'upload_timestamp' => now(),
            'ocr_status' => 'pending',
            'cv_analysis_status' => 'pending'
        ]);
    }

    private function generateUniqueFilename(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return time() . '_' . uniqid() . '.' . $extension;
    }

    public function getById(int $id): ?Document
    {
        return Document::find($id);
    }

    public function listAll(int $perPage = 15)
    {
        return Document::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function delete(int $id): bool
    {
        $document = $this->getById($id);
        if (!$document) {
            return false;
        }

        Storage::disk('local')->delete($document->storage_path);
        $document->delete();

        return true;
    }

    public function getStoragePath(Document $document): ?string
    {
        $path = Storage::disk('local')->path($document->storage_path);
        return file_exists($path) ? $path : null;
    }
}