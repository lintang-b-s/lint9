<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            //
            $table->foreign('blog_post_id', 'fk_post_categories_to_posts')->references('id')->on('blog_posts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('category_id', 'fk_post_categories_to_categories')->references('id')->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            //
            $table->dropForeign('fk_post_categories_to_posts');
            $table->dropForeign('fk_post_categories_to_categories');
        });
    }
}
