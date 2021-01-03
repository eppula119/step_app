<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clears', function (Blueprint $table) {
            //　クリアテーブル作成
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('child_id');
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('child_id')->references('id')->on('child_steps');
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
        Schema::dropIfExists('clears');
    }
}
