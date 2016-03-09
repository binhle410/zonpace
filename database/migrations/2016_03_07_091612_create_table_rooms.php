<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('house_id', false, true)->length(10);
            $table->string('name');
            $table->integer('room_no', false, true)->length(10);
            $table->integer('accommodates', false, true)->length(10);
            $table->integer('bedrooms', false, true)->length(10);
            $table->integer('beds', false, true)->length(10);
            $table->integer('bathrooms', false, true)->length(10);
            $table->tinyInteger('max_guest', false, true)->length(2);
            $table->timestamps();

            $table->foreign('house_id')
                ->references('id')->on('houses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
