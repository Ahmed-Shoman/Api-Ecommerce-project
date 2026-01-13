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
            $table->bigInteger('category_id')->unsigend();
            $table->bigInteger('brand_id')->unsigend();
            $table->foreignId('category_id')->onDelete()->cascade();
            $table->foreignId('brand_id')->onDelete()->cascade();
            $table->string('name');
            $table->boolean('is_trendy')->deafault('false');
            $table->boolean('is_available')->deafault('false');
            $table->double('price',8,2);
            $table->integer('amount');
            $table->double('discount',8,2)->nullable();
            $table->string('image');
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
