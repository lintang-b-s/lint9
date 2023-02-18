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
            $table->string('meta_title');
            $table->string('slug');
            $table->text('product_description');
            
            $table->foreignId('supplier_id')->nullable()->index('fk_products_to_suppliers');
            // $table->foreign('supplier_id', 'fk_products_to_suppliers')->references('id')->on('suppliers')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->foreignId('discount_id')->nullable()->index('fk_products_to_discounts');
            // $table->foreign('category_id', 'fk_products_to_categories')->references('id')->on('product_categories')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('quantity');
            $table->decimal('unit_price');
            $table->string('size');
            $table->decimal('weight');
            $table->longText('picture')->nullable();
            $table->integer('ranking')->nullable();
            $table->integer('sold')->nullable();
            $table->integer('review_total')->nullable();


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
