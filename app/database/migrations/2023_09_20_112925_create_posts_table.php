<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recruit_title');
            $table->string('game_id');
            $table->string('discord_url');
            $table->text('comment');
            $table->boolean('del_flg')->default(0);
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
