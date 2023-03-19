<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->index('fk_order_items_to_products');
            // $table->foreign('product_id', 'fk_order_items_to_products')->references('id')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->decimal('price');
            $table->integer('quantity');
            $table->string('sku');
            $table->decimal('discount');
            $table->decimal('total');
            $table->string('size');
            $table->dateTime('ship_date')->nullable();;
       

            $table->foreignId('order_id')->nullable()->index('fk_order_items_to_orders');
            $table->foreign('order_id', 'fk_order_items_to_orders')->references('id')->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');

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
        Schema::dropIfExists('order_items');
    }
}
