<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use App\Services\OcrService;
use App\Services\CvAnalysisService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    private DocumentService $documentService;
    private OcrService $ocrService;
    private CvAnalysisService $cvAnalysisService;

    public function __construct(DocumentService $documentService, OcrService $ocrService, CvAnalysisService $cvAnalysisService)
    {
        $this->documentService = $documentService;
        $this->ocrService = $ocrService;
        $this->cvAnalysisService = $cvAnalysisService;
    }

    public function index(): View
    {
        $documents = $this->documentService->listAll();
        return view('documents.index', compact('documents'));
    }

    public function uploadForm(): View
    {
        return view('documents.upload');
    }

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $result = $this->documentService->upload($request->file('file'));

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 422);
        }

        return response()->json([
            'message' => 'File uploaded successfully',
            'document' => $result['document']
        ], 201);
    }

    public function show(int $id): View
    {
        $document = $this->documentService->getById($id);
        if (!$document) {
            abort(404, 'Document not found');
        }
        return view('documents.show', compact('document'));
    }

    public function getStatus(int $id): JsonResponse
    {
        $document = $this->documentService->getById($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        return response()->json([
            'id' => $document->id,
            'ocr_status' => $document->ocr_status,
            'ocr_result' => $document->ocr_result,
            'cv_analysis_status' => $document->cv_analysis_status,
            'cv_is_cv' => $document->cv_is_cv,
            'cv_quality_score' => $document->cv_quality_score,
        ]);
    }

    public function runOcr(int $id): JsonResponse
    {
        $document = $this->documentService->getById($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        if (!$document->canRunOcr()) {
            return response()->json(['message' => 'OCR cannot be run in current state'], 422);
        }

        $result = $this->ocrService->process($document);

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    public function runCvAnalysis(int $id): JsonResponse
    {
        $document = $this->documentService->getById($id);
        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        if (!$document->canRunCvAnalysis()) {
            return response()->json(['message' => 'CV Analysis cannot be run. OCR must be completed first.'], 422);
        }

        $result = $this->cvAnalysisService->analyze($document);

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    public function destroy(int $id): JsonResponse
    {
        $success = $this->documentService->delete($id);

        if (!$success) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        return response()->json(['message' => 'Document deleted successfully']);
    }
}