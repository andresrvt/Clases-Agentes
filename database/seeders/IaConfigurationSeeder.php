<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IaConfiguration;

class IaConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        IaConfiguration::updateOrCreate(
            ['process_name' => 'ocr'],
            [
                'model' => 'glm-ocr:q8_0',
                'prompt' => 'Transcribe this document exactly as written. Preserve all text, formatting hints, and structure.',
                'status' => 'active'
            ]
        );

        IaConfiguration::updateOrCreate(
            ['process_name' => 'cv_analysis'],
            [
                'model' => 'gemma4:e2b',
                'prompt' => 'Analyze this document. If it is a CV/resume, determine if it appears to be a quality candidate. Rate the overall quality from 0 to 100. Respond with JSON: {"is_cv": true/false, "quality_score": 0-100, "reasoning": "brief explanation"}',
                'status' => 'active'
            ]
        );
    }
}