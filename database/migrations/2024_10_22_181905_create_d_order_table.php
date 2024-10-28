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
        Schema::create('d_order', function (Blueprint $table) {
            $table->bigIncrements('order_detail_id');
            $table->bigInteger('Order_no')->unsigned();
            $table->foreign('Order_no')->references('Order_no')->on('h_order');
            $table->string('goods_id', 10);
            $table->foreign('goods_id')->references('goods_id')->on('goods_name');
            $table->date('Ord_date');
            $table->date('Fin_date')->nullable();
            $table->smallInteger('amount')->default(0);
            $table->float('cost_unit')->default(0);
            $table->float('tot_prc')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_order');
    }
};
