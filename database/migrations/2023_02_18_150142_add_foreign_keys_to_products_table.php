<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->foreign('supplier_id', 'fk_products_to_suppliers')->references('id')->on('suppliers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('discount_id', 'fk_products_to_discounts')->references('id')->on('discounts')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropForeign('fk_products_to_suppliers');
            $table->dropForeign('fk_products_to_discounts');


        });
    }
}
