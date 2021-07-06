<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('prefix')->nullable();
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('member')->nullable();
            $table->text('picture')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedBigInteger('roles_id')->nullable();
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');

            $table->unsignedBigInteger('clubs_id')->nullable();
            $table->foreign('clubs_id')->references('id')->on('clubs')->onDelete('cascade');
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
}
