<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dmms_monitoring_records', function (Blueprint $table) {
            $table->id();
            $table->string('farm_name');
            $table->string('zone')->nullable();
            $table->decimal('temperature_c', 5, 2)->nullable();
            $table->decimal('humidity_pct', 5, 2)->nullable();
            $table->unsignedInteger('co2_ppm')->nullable();
            $table->string('alert_message')->nullable();
            $table->dateTime('recorded_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dmms_monitoring_records');
    }
};
