<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') &&
            !Schema::hasColumn('username', 'first_name', 'last_name', 'phone', 'data_serialized')
        )
        {
            Schema::table('users', function($table)
            {
                $table->string('first_name')->after('name');
                $table->string('last_name')->after('first_name');
                $table->string('phone')->after('last_name');
                $table->text('data_serialized')->after('email');
                $table->renameColumn('name', 'username');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn(['username', 'first_name', 'last_name', 'phone', 'data_serialized']);
            $table->renameColumn('username', 'name');
        });
    }
}
