<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->length('10');
            $table->string('name');
            $table->string('display_name');
            $table->integer('nor', false, true)->length(11);
            $table->integer('max_guest', false, true)->length(10);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->dropForeign('houses_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('houses');
    }
}
