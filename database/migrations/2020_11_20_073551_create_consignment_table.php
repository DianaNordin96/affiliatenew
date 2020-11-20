<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignment', function (Blueprint $table) {
            $table->id();
            $table->string('REQ_ID')->nullable();
            $table->string('refNo')->nullable();
            $table->string('parcel_number')->nullable();
            $table->string('order_number')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('courier')->nullable();
            $table->string('collect_date')->nullable();
            $table->string('messagenow')->nullable();
            $table->string('awb')->nullable();
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
        Schema::dropIfExists('consignment');
    }
}
