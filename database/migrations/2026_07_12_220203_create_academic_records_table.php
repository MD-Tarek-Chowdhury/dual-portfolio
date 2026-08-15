<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->enum('record_type', ['publication', 'course', 'designation', 'achievement']);
            $table->string('title', 255);
            $table->string('subtitle_or_institution', 255)->nullable();
            $table->string('date_or_year', 30)->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 255)->unique();
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['record_type', 'is_active', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_records');
    }
};
