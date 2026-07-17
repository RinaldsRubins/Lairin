<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Merged into 2026_07_16_000001_create_services_table.php
    }

    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
