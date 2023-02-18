<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->foreign('shipper_id', 'fk_orders_to_shippers')->references('id')->on('shippers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('payment_id', 'fk_orders_to_payments')->references('id')->on('payments')->onUpdate('CASCADE')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('fk_orders_to_shippers');
            $table->dropForeign('fk_orders_to_payments');

        });
    }
}
