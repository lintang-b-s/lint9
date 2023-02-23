<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('received_date_est');
            $table->float('packaging_cost');
            $table->float('shipping_fee_wg');
            $table->float('shipping_fee_ds');
            $table->foreignId('shipper_id')->nullable()->index('fk_shipment_types_to_shippers');
            $table->foreign('shipper_id', 'fk_shipment_types_to_shippers')->references('id')->on('shippers')->onUpdate('CASCADE')->onDelete('CASCADE');


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
        Schema::dropIfExists('shipment_types');
    }
}
