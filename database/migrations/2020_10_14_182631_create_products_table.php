<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('product_description')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_image')->nullable();
            $table->text('product_link')->nullable();
            $table->string('product_cost')->nullable();
            $table->string('shogun_cost')->nullable();
            $table->string('damio_cost')->nullable();
            $table->string('merchant_cost')->nullable();
            $table->string('dropship_cost')->nullable();
            $table->string('price_shogun')->nullable();
            $table->string('price_damio')->nullable();
            $table->string('price_merchant')->nullable();
            $table->string('price_dropship')->nullable();
            $table->string('price_hq')->nullable();
            $table->bigInteger('belongToAdmin')->nullable();
            $table->bigInteger('product_cat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
