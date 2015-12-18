<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inspection_id')->unsigned()->index();
            $table->bigInteger('job_inspect_id')->unsigned()->index();
            $table->bigInteger('scope_id')->unsigned()->index();
            $table->string('type', 32);
            $table->string('url');
            $table->text('description');
            $table->string('issue_line')->nullable();

            $table->foreign('inspection_id')
                  ->references('id')
                  ->on('inspections')
                  ->onDelete('cascade');
            $table->foreign('job_inspect_id')
                  ->references('id')
                  ->on('job_inspects')
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
        Schema::drop('issues');
    }
}
