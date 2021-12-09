<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_areas', function (Blueprint $table) {
            $table->id();
            $table->text("service_area_name");
            $table->timestamps();
        });

        DB::table('service_areas')->insert(array(
                                    'service_area_name' => 'Electricity',
                                    ));

        DB::table('service_areas')->insert(array(
                                    'service_area_name' => 'Water',
                                    ));

        DB::table('service_areas')->insert(array(
                                    'service_area_name' => 'Air Conditioning',
                                    ));

        DB::table('service_areas')->insert(array(
                                    'service_area_name' => 'Other',
                                    ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_areas');
    }
}
