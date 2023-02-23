<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('resi');
            $table->foreignId('ship_type_id')->nullable()->index('fk_shipments_to_shipment_types');
            $table->foreignId('order_id')->nullable()->index('fk_shipments_to_orders');
            $table->foreign('order_id', 'fk_shipments_to_orders')->references('id')->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');

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
        Schema::dropIfExists('shipments');
    }
}
