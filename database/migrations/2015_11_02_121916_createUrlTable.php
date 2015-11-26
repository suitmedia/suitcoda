<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned()->index();
            $table->string('type');
            $table->string('url');
            $table->tinyInteger('depth')->unsigned()->default(0);
            $table->string('title')->nullable();
            $table->string('title_tag')->nullable();
            $table->text('desc')->nullable();
            $table->text('desc_tag')->nullable();
            $table->binary('body_content');
            $table->boolean('is_active')->default(false);

            $table->foreign('project_id')
                  ->references('id')->on('projects')
                  ->onDelete('cascade');
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
        Schema::drop('urls');
    }
}
