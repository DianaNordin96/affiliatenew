<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->bigInteger('admin_category')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('icnumber')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('dob')->nullable();
            $table->bigInteger('downlineTo')->nullable();
            $table->bigInteger('belongsToAdmin')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('statusDownline')->nullable();
            $table->string('password')->nullable();
            $table->string('commissionPoint')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
