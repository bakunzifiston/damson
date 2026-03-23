<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_resources', function (Blueprint $table) {
            $table->id();
            $table->string('category', 64);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('resource_type', 32)->default('document');
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_resources');
    }
};
