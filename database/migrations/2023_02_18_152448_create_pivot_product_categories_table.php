<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->index('fk_pivot_product_categories_to_product_categories');
            $table->foreignId('product_id')->nullable()->index('fk_pivot_product_categories_to_products');

            $table->foreign('category_id', 'fk_pivot_product_categories_to_product_categories')->references('id')->on('product_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('product_id', 'fk_pivot_product_categories_to_products')->references('id')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');

        
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
        Schema::dropIfExists('pivot_product_categories');
    }
}
