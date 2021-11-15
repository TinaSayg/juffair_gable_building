<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_statuses', function (Blueprint $table) {
            $table->integer('building_status_id');
            $table->string('building_status_name');
            $table->integer('building_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('building_statuses')->insert(array('building_status_id' => '1',
                                                 'building_status_name' => 'Active',
                                                 'building_status_code' => '1'));

        DB::table('building_statuses')->insert(array('building_status_id' => '2',
                                                 'building_status_name' => 'Inactive',
                                                 'building_status_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('building_statuses');
    }
}
