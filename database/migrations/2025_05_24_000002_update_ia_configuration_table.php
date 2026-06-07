<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ia_configuration', function (Blueprint $table) {
            $table->renameColumn('job', 'process_name');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('process_name');
        });
    }

    public function down(): void
    {
        Schema::table('ia_configuration', function (Blueprint $table) {
            $table->renameColumn('process_name', 'job');
            $table->dropColumn('status');
        });
    }
};