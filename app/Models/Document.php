<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'original_filename',
        'storage_path',
        'file_size',
        'upload_timestamp',
        'ocr_status',
        'ocr_result',
        'ocr_completed_at',
        'cv_analysis_status',
        'cv_is_cv',
        'cv_quality_score',
        'cv_analysis_completed_at'
    ];

    protected $casts = [
        'cv_is_cv' => 'boolean',
        'cv_quality_score' => 'integer',
        'upload_timestamp' => 'datetime',
        'ocr_completed_at' => 'datetime',
        'cv_analysis_completed_at' => 'datetime',
    ];

    public function isOcrCompleted(): bool
    {
        return $this->ocr_status === 'completed';
    }

    public function isCvAnalysisCompleted(): bool
    {
        return $this->cv_analysis_status === 'completed';
    }

    public function canRunOcr(): bool
    {
        return $this->ocr_status === 'pending' || $this->ocr_status === 'failed';
    }

    public function canRunCvAnalysis(): bool
    {
        return $this->ocr_status === 'completed' && ($this->cv_analysis_status === 'pending' || $this->cv_analysis_status === 'failed');
    }
}