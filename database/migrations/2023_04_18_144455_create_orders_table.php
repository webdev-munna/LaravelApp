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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderId');
            $table->integer('customerId');
            $table->integer('subTotal');
            $table->integer('discount')->nullable();
            $table->integer('charge')->nullable();
            $table->integer('total');
            $table->integer('paymentMethod');
            $table->integer('orderStatus')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
