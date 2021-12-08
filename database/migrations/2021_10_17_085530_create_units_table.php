<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number');
            $table->string('apartment_type');
            $table->string('unit_rent')->nullable();
            $table->string('color_code');
            $table->integer('no_of_bed_rooms');
            $table->string('unit_area');
            
            $table->string('floor_id');
            $table->integer('unit_status_code');
            
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
        Schema::dropIfExists('units');
    }
}
