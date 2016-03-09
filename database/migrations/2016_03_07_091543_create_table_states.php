<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('overall', 20)->nullable();
            $table->string('payment', 20)->nullable();
            $table->string('delivery', 20)->nullable();
            $table->string('return', 20)->nullable();
            $table->string('refund', 20)->nullable();
            $table->string('cancel', 20)->nullable();
            $table->string('custom', 20)->nullable();
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
        Schema::drop('states');
    }
}
