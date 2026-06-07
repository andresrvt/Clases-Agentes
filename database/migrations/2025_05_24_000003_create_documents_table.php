<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename');
            $table->string('storage_path');
            $table->bigInteger('file_size');
            $table->timestamp('upload_timestamp')->useCurrent();
            $table->enum('ocr_status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->longText('ocr_result')->nullable();
            $table->timestamp('ocr_completed_at')->nullable();
            $table->enum('cv_analysis_status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->boolean('cv_is_cv')->nullable();
            $table->integer('cv_quality_score')->nullable();
            $table->timestamp('cv_analysis_completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};