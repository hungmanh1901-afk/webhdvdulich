<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_languages', function (Blueprint $table) {
            $table->foreignId('guide_id')->constrained('guides')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->primary(['guide_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_languages');
    }
};
