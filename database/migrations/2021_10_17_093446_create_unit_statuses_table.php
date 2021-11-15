<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_statuses', function (Blueprint $table) {
            $table->integer('unit_status_id');
            $table->string('unit_status_name');
            $table->integer('unit_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('unit_statuses')->insert(array('unit_status_id' => '1',
                                             'unit_status_name' => 'Rented',
                                             'unit_status_code' => '1'));

        DB::table('unit_statuses')->insert(array('unit_status_id' => '2',
                                             'unit_status_name' => 'Vacant',
                                             'unit_status_code' => '2'));

        DB::table('unit_statuses')->insert(array('unit_status_id' => '3',
                                             'unit_status_name' => 'Under Renovation',
                                             'unit_status_code' => '3'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_statuses');
    }
}
