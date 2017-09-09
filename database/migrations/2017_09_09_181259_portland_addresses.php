<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PortlandAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portland_addresses', function (Blueprint $table) {
            $table->integer('objectid')->nullable(); 

            $table->string('add_num_ch')->nullable(); 
            $table->string('str_predir')->nullable(); 
            $table->string('str_name')->nullable(); 
            $table->string('str_type_c')->nullable(); 
            $table->string('str_nm_ful')->nullable(); 
            $table->string('unit_value')->nullable(); 
            $table->string('add_full')->nullable(); 
            $table->string('city')->nullable(); 
            $table->string('state')->nullable(); 
            $table->string('state_abbr')->nullable(); 
            $table->string('zip_code')->nullable(); 
            $table->string('juris')->nullable(); 

            // The original coordinates in the dataset
            $table->double('x')->nullable();
            $table->double('y')->nullable();

            // Lat/Long coordinates
            $table->double('lat', 16, 13)->nullable();
            $table->double('lng', 16, 13)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portland_addresses');
    }
}
