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
            $table->integer('order_number');
            // $table->uuid('payment_id')
            $table->foreignId('payment_id')->nullable()->index('fk_orders_to_payments');
            // $table->foreign('payment_id', 'fk_orders_to_payments')->references('id')->on('payments')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->dateTime('order_date');
            $table->dateTime('payment_date')->nullable();
            $table->dateTime('ship_date')->nullable();
            $table->dateTime('delivered_date')->nullable();
            $table->dateTime('cancel_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->string('return_reason')->nullable();

            $table->foreignId('shipper_id')->nullable()->index('fk_payments_to_shippers');
            // $table->foreign('shipper_id', 'fk_payments_to_shippers')->references('id')->on('shippers')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('freight')->nullable();
            $table->enum('status', ['Cancel', 'Paid', 'Pending']);



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
