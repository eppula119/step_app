<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_steps', function (Blueprint $table) {
          //　子STEPテーブル作成
          $table->increments('id');
          $table->string('title');
          $table->string('content', 10000);
          $table->unsignedInteger('step_id');
          $table->string('image')->nullable();
          $table->integer('time');
          $table->dateTime('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
          $table->boolean('delete_flg')->nullable()->default(0);

          $table->foreign('step_id')->references('id')->on('steps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_steps');
    }
}
