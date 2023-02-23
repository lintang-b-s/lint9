<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('status_date')->nullable();
            $table->string('reason')->nullable();
            $table->foreignId('order_id')->nullable()->index('fk_order_statuses_to_orders');
            $table->foreign('order_id', 'fk_order_statuses_to_orders')->references('id')->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');


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
        Schema::dropIfExists('order_statuses');
    }
}
