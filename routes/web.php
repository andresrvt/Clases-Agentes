<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ai-configuration', function () {
    return view('ai-configuration');
});

Route::get('/documents', [DocumentController::class, 'index']);
Route::get('/documents/upload', [DocumentController::class, 'uploadForm']);
Route::post('/documents/upload', [DocumentController::class, 'upload']);
Route::get('/documents/{id}', [DocumentController::class, 'show']);
Route::get('/documents/{id}/status', [DocumentController::class, 'getStatus']);
Route::post('/documents/{id}/ocr', [DocumentController::class, 'runOcr']);
Route::post('/documents/{id}/cv-analysis', [DocumentController::class, 'runCvAnalysis']);
Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);