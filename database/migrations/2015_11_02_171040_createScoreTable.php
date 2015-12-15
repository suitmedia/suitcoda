<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inspection_id')->unsigned()->index();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->double('score')->unsigned();

            $table->foreign('inspection_id')
                  ->references('id')->on('inspections')
                  ->onDelete('cascade');
            // $table->foreign('category_id')
            //       ->references('id')->on('categories')
            //       ->onDelete('cascade');
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
        Schema::drop('scores');
    }
}
