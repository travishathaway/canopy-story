<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add survey fields to the users table
        Schema::table('users', function(Blueprint $table){
            $table->integer('year_born')->nullable();
            $table->string('gender')->nullable();
            $table->string('race_ethnicity')->nullable();
            $table->string('home_zip_code')->nullable();
            $table->string('education')->nullable();
            $table->string('survey_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn([
                'year_born', 'gender', 'race_ethnicity', 
                'home_zip_code', 'education', 'survey_status'
            ]);
        });
    }
}
