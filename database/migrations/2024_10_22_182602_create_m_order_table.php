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
        Schema::create('m_order', function (Blueprint $table) {
            $table->string('cus_id', 5);
            $table->foreign('Cus_id')->references('cus_id')->on('cus_name');
            $table->string('goods_id', 10);
            $table->foreign('goods_id')->references('goods_id')->on('goods_name');
            $table->dateTime('Doc_date');
            $table->dateTime('Ord_date');
            $table->dateTime('Fin_date');
            $table->dateTime('Sys_date');
            $table->smallInteger('amount');
            $table->smallInteger('cost_tot');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_order');
    }
};
