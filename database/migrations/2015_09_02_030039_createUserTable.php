<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->string('name')->default('Anonymous');
            $table->string('slug')->unique();
            $table->date('date_of_birth')->nullable();
            
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_active')->default(false);
            $table->dateTime('last_login_at')->nullable();

            $table->string('remember_token')->default('');
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
        Schema::drop('users');
    }
}
