<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_name');
            $table->timestamps();
        });

        DB::table('locations')->insert(array(
                                'location_name' => 'Residential Area',
                                ));

        DB::table('locations')->insert(array(
                                'location_name' => 'Common Area',
                                ));

        DB::table('locations')->insert(array(
                                'location_name' => 'Parking Area',
                                ));

        DB::table('locations')->insert(array(
                                'location_name' => 'Services Area',
                                ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
