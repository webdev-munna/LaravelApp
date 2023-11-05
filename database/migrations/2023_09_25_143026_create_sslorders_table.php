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
        Schema::create('sslorders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->double('subtotal');
            $table->double('amount');
            $table->string('address');
            $table->string('status');
            $table->string('transaction_id');
            $table->string('currency');
            $table->string('order_id');
            $table->integer('customer_id');
            $table->integer('discount');
            $table->integer('charge');
            $table->string('company');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->integer('zip');
            $table->string('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sslorders');
    }
};
