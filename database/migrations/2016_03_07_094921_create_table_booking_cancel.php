<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookingCancel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_cancel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id', false, true)->length(10);
            $table->string('state_overall', 20)->nullable();
            $table->string('state_custom', 20)->nullable();
            $table->timestamps();

            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booking_cancel');
    }
}
