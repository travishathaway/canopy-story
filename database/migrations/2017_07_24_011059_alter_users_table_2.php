<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * Here, we are adding a new column to the users table called "age_range"
     *
     * They types of values we store in here will be:
     *  - under_18
     *  - 18_24
     *  - etc.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('age_range')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['age_range']);
        });
    }
}
