<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('city_id');
            $table->string('city_name');
        });

        // Insert Pre-populated Table Values
        DB::table('cities')->insert(array('city_id' => '1',
                                      'city_name' => 'Manama'));
        DB::table('cities')->insert(array('city_id' => '2',
                                      'city_name' => 'Muharraq'));
        DB::table('cities')->insert(array('city_id' => '3',
                                      'city_name' => 'Isa Town'));
        DB::table('cities')->insert(array('city_id' => '4',
                                      'city_name' => 'Godabiya'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
