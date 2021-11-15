<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_statuses', function (Blueprint $table) {
            $table->integer('owner_status_id');
            $table->string('owner_status_name');
            $table->integer('owner_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('owner_statuses')->insert(array('owner_status_id' => '1',
                                              'owner_status_name' => 'Pending',
                                              'owner_status_code' => '1'));

        DB::table('owner_statuses')->insert(array('owner_status_id' => '2',
                                              'owner_status_name' => 'Active',
                                              'owner_status_code' => '2'));

        DB::table('owner_statuses')->insert(array('owner_status_id' => '3',
                                              'owner_status_name' => 'Inactive',
                                              'owner_status_code' => '3'));

        DB::table('owner_statuses')->insert(array('owner_status_id' => '4',
                                              'owner_status_name' => 'Suspended',
                                              'owner_status_code' => '4'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_statuses');
    }
}
