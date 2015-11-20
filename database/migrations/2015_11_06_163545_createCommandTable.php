<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->BigInteger('scope_id')->unsigned()->index();
            $table->string('name');
            $table->string('command_line', 128);
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
        Schema::drop('commands');
    }
}
