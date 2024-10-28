<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('h_order', function (Blueprint $table) {
            $table->id('Order_no');
            $table->string('cus_id', 5);
            $table->foreign('Cus_id')->references('cus_id')->on('cus_name');
            $table->date('Order_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_order');
    }
};
