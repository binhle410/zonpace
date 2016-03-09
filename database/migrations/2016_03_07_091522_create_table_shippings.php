<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShippings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method', 50);
            $table->string('service', 50);
            $table->decimal('price', 10, 2)->default('0.00');
            $table->decimal('discount', 12, 2)->default('0.00');
            $table->tinyInteger('fee', false, true)->length(4);
            $table->text('data_serialized')->nullable();
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
        Schema::drop('shippings');
    }
}
