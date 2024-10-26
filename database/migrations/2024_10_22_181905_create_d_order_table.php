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
            $table->bigIncrements('Order_no');
            $table->foreign('Order_no')->references('order_no')->on('h_order');
            $table->string('cus_id', 5);
            $table->foreign('Cus_id')->references('cus_id')->on('cus_name');
            $table->dateTime('Ord_date');
            $table->dateTime('Fin_date')->nullable();
            $table->smallInteger('amount')->default(0);
            $table->smallInteger('cost_unit')->default(0);
            $table->smallInteger('tot_prc')->default(0);

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
