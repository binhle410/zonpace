<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToHousesTable extends Migration
{
    private $tbl = 'houses';
    private $col = 'status';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tbl, function(Blueprint $table)
        {
            $table->tinyInteger($this->col)->default(0)->unsigned()->after('max_guest');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tbl, function (Blueprint $table)
        {
            $table->dropColumn($this->col);
        });
    }
}
