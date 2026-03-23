<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('unit', 32)->default('piece')->after('category');
            $table->decimal('cost_price', 12, 2)->nullable()->after('price');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unique('sku');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['unit', 'cost_price']);
        });
    }
};
