<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->length(11);
            $table->string('work');
            $table->string('timezone');
            $table->string('locale');
            $table->tinyInteger('payment_id', false, true)->length(4);
            $table->tinyInteger('emergency_contact_id', false, true)->length(4);
            $table->tinyInteger('shipping_id', false, true)->length(4);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('profiles');
    }
}
