<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_types', function (Blueprint $table) {
            $table->integer('floor_type_id');
            $table->string('floor_type_name');
            $table->integer('floor_type_code');
        });

         // Insert Pre-populated Table Values
        DB::table('floor_types')->insert(array('floor_type_id' => '1',
                                        'floor_type_name' => 'Parking',
                                        'floor_type_code' => '1'));

        DB::table('floor_types')->insert(array('floor_type_id' => '2',
                                        'floor_type_name' => 'Residential',
                                        'floor_type_code' => '2'));
                                        
        DB::table('floor_types')->insert(array('floor_type_id' => '3',
                                        'floor_type_name' => 'Recreational',
                                        'floor_type_code' => '3'));
        DB::table('floor_types')->insert(array('floor_type_id' => '4',
                                        'floor_type_name' => 'Others',
                                        'floor_type_code' => '4'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floor_types');
    }
}
