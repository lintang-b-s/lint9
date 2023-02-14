<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->index('fk_order_details_to_products');
            // $table->foreign('product_id', 'fk_order_details_to_products')->references('id')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('order_number');
            $table->decimal('price');
            $table->integer('quantity');
            $table->decimal('discount');
            $table->decimal('total');
            $table->string('idsku')->nullable();
            $table->string('size');
            $table->dateTime('ship_date')->nullable();;
            $table->enum('status', ['Cancel', 'Paid', 'Pending']);

            $table->foreignId('order_id')->nullable()->index('fk_order_details_to_orders');
            $table->foreign('order_id', 'fk_order_details_to_orders')->references('id')->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->dateTime('delivered_date')->nullable();





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
        Schema::dropIfExists('order_details');
    }
}
