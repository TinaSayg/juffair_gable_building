<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_types', function (Blueprint $table) {
            $table->integer('unit_type_id');
            $table->string('unit_type_name');
            $table->integer('unit_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('unit_types')->insert(array('unit_type_id' => '1',
                                           'unit_type_name' => 'Undefined',
                                           'unit_type_code' => '1'));

        DB::table('unit_types')->insert(array('unit_type_id' => '2',
                                           'unit_type_name' => 'Residential Unit',
                                           'unit_type_code' => '2'));

        DB::table('unit_types')->insert(array('unit_type_id' => '3',
                                           'unit_type_name' => 'Commercial Unit',
                                           'unit_type_code' => '3'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_types');
    }
}
