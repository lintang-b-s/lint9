<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
        
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sessionId');
            $table->string('content');
            $table->string('type');
            $table->string('token');
        
            $table->float('subTotal');
            $table->float('itemDiscount');
            $table->float('tax');
            $table->float('shipping');
            $table->float('total');
            $table->float('discount');
            $table->float('grandTotal');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address_line');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country');
            $table->dateTime('order_date');
            $table->dateTime('payment_date')->nullable();
            $table->unsignedBigInteger('ship_type_id');
            // $table->dateTime('required_date')->nullable();
            $table->foreignId('payment_id')->nullable()->index('fk_orders_to_payments');
            $table->string('freight')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
