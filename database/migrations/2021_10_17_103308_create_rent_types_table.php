<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_types', function (Blueprint $table) {
            $table->integer('rent_type_id');
            $table->string('rent_type_name');
            $table->integer('rent_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('rent_types')->insert(array('rent_type_id' => '1',
                                                'rent_type_name' => 'Inclusive',
                                                'rent_type_code' => '1'));

        DB::table('rent_types')->insert(array('rent_type_id' => '2',
                                                'rent_type_name' => 'Exclusive',
                                                'rent_type_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_types');
    }
}
