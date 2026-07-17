<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->json('schema_markup')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
