<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ia_configuration', function (Blueprint $table) {
            $table->id();
            $table->text('prompt')->nullable();
            $table->string('model')->nullable();
            $table->string('job')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ia_configuration');
    }
};