<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            //　チャレンジテーブル作成
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('step_id');
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('step_id')->references('id')->on('steps');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
}
