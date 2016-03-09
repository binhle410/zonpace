<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booker_id', false, true)->length(10);
            $table->integer('house_id', false, true)->length(10);
            $table->integer('room_id', false, true)->length(10);
            $table->decimal('discount_amount', 12, 2);
            $table->decimal('discount_percent', 12, 2);
            $table->decimal('amount_paid', 12, 2);
            $table->decimal('amount_due', 12, 2);
            $table->decimal('amount_refund', 12, 2);
            $table->decimal('grand_total', 12, 2);
            $table->integer('shipping_id', false, true)->length(10);
            $table->integer('billing_id', false, true)->length(10);
            $table->integer('state_id', false, true)->length(10);
            $table->timestamps();

            $table->foreign('booker_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('house_id')
                ->references('id')->on('houses');
            $table->foreign('room_id')
                ->references('id')->on('rooms');
            $table->foreign('shipping_id')
                ->references('id')->on('shippings');
            $table->foreign('billing_id')
                ->references('id')->on('billings');
            $table->foreign('state_id')
                ->references('id')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bookings');
    }
}
