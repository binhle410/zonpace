<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBillings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company', 50)->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('street');
            $table->string('street_ext');
            $table->string('city', 50)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
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
        Schema::drop('billings');
    }
}
