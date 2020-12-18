<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post__comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->integer('user_id');
            $table->text('comment');
            $table->integer('reply_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->dateTime('date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post__comments');
    }
}
