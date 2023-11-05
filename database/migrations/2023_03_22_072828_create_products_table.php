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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('categoryId');
            $table->integer('subcategoryId');
            $table->string('productName');
            $table->string('slug');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('afterDiscount');
            $table->string('brand')->nullable();
            $table->string('shortDescription')->nullable();
            $table->longText('longDescription')->nullable();
            $table->string('previewImage')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
