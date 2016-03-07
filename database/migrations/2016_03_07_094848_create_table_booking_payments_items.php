<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookingPaymentsItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payment_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id', false, true)->length(10);
            $table->integer('booking_payment_id', false, true)->length(10);
            $table->timestamps();

            $table->foreign('booking_id')
                ->references('id')->on('bookings');
            $table->foreign('booking_payment_id')
                ->references('id')->on('booking_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booking_payment_items');
    }
}
