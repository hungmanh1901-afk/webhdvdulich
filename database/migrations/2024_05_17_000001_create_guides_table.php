<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('address', 255)->nullable();
            $table->unsignedInteger('experience_years')->default(0);
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 10, 2);
            $table->string('avatar', 255)->nullable();
            $table->enum('status', ['available', 'busy', 'inactive'])->default('available');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
