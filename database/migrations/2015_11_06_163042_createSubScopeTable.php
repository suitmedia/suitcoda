<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubScopeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_scopes', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->BigInteger('scope_id')->unsigned()->index();
            $table->string('name');
            $table->BigInteger('code');
            $table->string('parameter', 64);
            $table->boolean('is_active')->default(true);

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
        Schema::drop('sub_scopes');
    }
}
