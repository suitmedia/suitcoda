<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobInspectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_inspects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inspection_id')->unsigned()->index();
            $table->bigInteger('url_id')->unsigned()->index();
            $table->bigInteger('scope_id')->unsigned()->index();
            $table->string('command_line', 512);
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('issue_count')->nullable();

            $table->foreign('inspection_id')
                  ->references('id')
                  ->on('inspections')
                  ->onDelete('cascade');
            $table->foreign('url_id')
                  ->references('id')
                  ->on('urls')
                  ->onDelete('cascade');
            $table->foreign('scope_id')
                  ->references('id')
                  ->on('scopes')
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
        Schema::drop('job_inspects');
    }
}
