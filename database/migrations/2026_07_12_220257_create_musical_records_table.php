<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('musical_records', function (Blueprint $table) {
            $table->id();
            $table->enum('record_type', ['band_info', 'discography', 'instrument', 'course']);
            $table->string('title', 255);
            $table->string('media_url', 500)->nullable();
            $table->text('body')->nullable();
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
        Schema::dropIfExists('musical_records');
    }
};
