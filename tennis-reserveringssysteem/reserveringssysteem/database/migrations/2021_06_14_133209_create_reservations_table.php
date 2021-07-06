<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('starttime');
            $table->dateTime('endtime');
            $table->string('nameEvent')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('courts_id')->nullable();
            $table->foreign('courts_id')->references('id')->on('courts')->onDelete('cascade');

            $table->unsignedBigInteger('reservations_kinds_id');
            $table->foreign('reservations_kinds_id')->references('id')->on('reservation_kind')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
