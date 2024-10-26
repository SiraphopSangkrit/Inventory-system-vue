<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_name', function (Blueprint $table) {
            $table->string('Goods_id',10)->primary();
            $table->string('Goods_name',30);
            $table->decimal('cost_unit',8,2);
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_name');
    }
};
