<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('idsku');
            $table->string('product_name');
            $table->text('product_description');
            
            $table->foreignId('supplier_id')->nullable()->index('fk_products_to_suppliers');
            // $table->foreign('supplier_id', 'fk_products_to_suppliers')->references('id')->on('suppliers')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreignId('category_id')->nullable()->index('fk_products_to_categories');
            // $table->foreign('category_id', 'fk_products_to_categories')->references('id')->on('product_categories')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('quantity');
            $table->decimal('unit_price');
            $table->string('size');
            $table->decimal('discount')->nullable();
            $table->decimal('weight');
            $table->longText('picture')->nullable();
            $table->integer('ranking')->nullable();


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
        Schema::dropIfExists('products');
    }
}
