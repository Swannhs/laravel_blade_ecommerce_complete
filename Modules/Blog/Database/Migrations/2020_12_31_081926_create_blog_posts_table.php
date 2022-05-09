<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger("author_id")->nullable();
            $table->string("title");
            $table->string('slug')->unique();
            $table->text("content");
            $table->string('image_url')->nullable();
            $table->boolean("status")->default(0);
            $table->boolean("is_approved")->default(0);
            $table->unsignedBigInteger("view_count")->default(0);
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->boolean("is_commentable")->default(1);
            $table->timestamp("published_at")->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
}
