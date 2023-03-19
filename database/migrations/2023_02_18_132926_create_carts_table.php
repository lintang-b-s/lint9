<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('session_id');
            $table->string('token');
            $table->string('status');
            $table->string('content');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address_line');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country');
            
            
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
        Schema::dropIfExists('carts');
    }
}
