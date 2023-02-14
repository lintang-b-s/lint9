<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPostTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_tags', function (Blueprint $table) {
            //
            $table->foreign('blog_post_id', 'fk_post_tags_to_posts')->references('id')->on('blog_posts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tag_id', 'fk_post_tags_to_tags')->references('id')->on('tags')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_tags', function (Blueprint $table) {
            //
            $table->dropForeign('fk_post_tags_to_posts');
            $table->dropForeign('fk_post_tags_to_tags');
        });
    }
}
