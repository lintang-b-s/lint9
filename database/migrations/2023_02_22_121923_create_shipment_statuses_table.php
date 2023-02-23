<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->dateTime('status_date');
            $table->foreignId('ship_id')->nullable()->index('fk_shipment_statuses_to_shipments');
            $table->foreign('ship_id', 'fk_shipment_statuses_to_shipments')->references('id')->on('shipments')->onUpdate('CASCADE')->onDelete('CASCADE');
            
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
        Schema::dropIfExists('shipment_statuses');
    }
}
