<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incubation_records', function (Blueprint $table) {
            $table->id();
            $table->string('batch_reference');
            $table->string('species');
            $table->date('incubation_start');
            $table->date('expected_fruit')->nullable();
            $table->string('phase', 64)->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incubation_records');
    }
};
