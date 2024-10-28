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
            $table->bigIncrements('m_order_id');
            $table->string('cus_id', 5);
            $table->foreign('Cus_id')->references('cus_id')->on('cus_name');
            $table->string('goods_id', 10);
            $table->foreign('goods_id')->references('goods_id')->on('goods_name');
            $table->date('Doc_date');
            $table->date('Ord_date');
            $table->date('Fin_date');
            $table->date('Sys_date');
            $table->float('amount');
            $table->float('cost_tot');
            $table->timestamps();
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
