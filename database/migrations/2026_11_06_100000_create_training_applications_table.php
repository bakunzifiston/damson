<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone', 32);
            $table->string('email');
            $table->string('district');
            $table->string('training_mode', 16);          // online | on_site
            $table->json('interests');                    // list of selected training areas
            $table->string('experience', 16);             // yes | no | basic
            $table->string('start_preference', 24);       // asap | within_month | flexible
            $table->text('objective');
            $table->string('status', 16)->default('new')->index();
            $table->text('admin_notes')->nullable();      // internal, never shown publicly
            $table->timestamps();

            $table->index('created_at');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_applications');
    }
};
