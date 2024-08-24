<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Fname',50)->nullable();
            $table->string('Lname',50)->nullable();
            $table->string('Phone',20);
            $table->string('Country',50)->nullable();
            $table->string('City',50)->nullable();
            $table->string('email',50);
            $table->timestamp('Email_verified_at')->nullable();
            $table->string('password');
            $table->integer('Type_User')->nullable();
            $table->integer('weight')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('gender')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
