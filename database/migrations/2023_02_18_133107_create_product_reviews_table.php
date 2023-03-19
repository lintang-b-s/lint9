<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('customer_id');
            $table->foreignId('product_id')->nullable()->index('fk_product_reviews_to_products');
            $table->foreign('customer_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->integer('rating');
            $table->string('published');

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
        Schema::dropIfExists('product_reviews');
    }
}
