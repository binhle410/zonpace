<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookingPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id', false, true)->length(10);
            $table->string('payment_method');
            $table->decimal('amount_due', 12, 2);
            $table->decimal('amount_refund', 12, 2);
            $table->integer('transaction_id', false, true)->length(10);
            $table->string('transaction_status', 50);
            $table->string('transaction_token', 50);
            $table->string('transaction_type', 50);
            $table->decimal('transaction_fee', 12, 2);
            $table->string('state_overall', 20)->nullable();
            $table->string('state_custom', 20)->nullable();
            $table->tinyInteger('online', false, true)->length(1)->default(1);
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
        Schema::drop('booking_payments');
    }
}
