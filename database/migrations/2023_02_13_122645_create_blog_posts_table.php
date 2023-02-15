<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->uuid('author_id');
            $table->foreign('author_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');            
            $table->string('title');
            $table->string('metaTitle');
            $table->string('slug');
            $table->text('summary');
            $table->text('content');
            $table->string('published');
            $table->longText('thumbnail')->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
}
