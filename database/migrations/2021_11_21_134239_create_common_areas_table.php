<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_areas', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->integer('location_id');
            $table->timestamps();
        });

        DB::table('common_areas')->insert(array(
                                'area_name' => 'Roof',
                                'location_id' => '2'
                                ));

        DB::table('common_areas')->insert(array(
                                'area_name' => 'Recreational floor',
                                'location_id' => '2'
                                ));

        DB::table('common_areas')->insert(array(
                                'area_name' => 'Looby floor',
                                'location_id' => '2'
                                ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_areas');
    }
}
