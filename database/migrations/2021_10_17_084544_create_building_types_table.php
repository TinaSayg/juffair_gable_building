<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_types', function (Blueprint $table) {
            $table->integer('building_type_id');
            $table->string('building_type_name');
            $table->integer('building_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('building_types')->insert(array('building_type_id' => '1',
                                               'building_type_name' => 'Building Type 1',
                                               'building_type_code' => '1'));

        DB::table('building_types')->insert(array('building_type_id' => '2',
                                               'building_type_name' => 'Building Type 2',
                                               'building_type_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_types');
    }
}
