<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_request_status', function (Blueprint $table) {
            $table->integer('maintenance_request_status_id');
            $table->string('maintenance_request_status_name');
            $table->integer('maintenance_request_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('maintenance_request_status')->insert(array('maintenance_request_status_id' => '1',
                                'maintenance_request_status_name' => 'Submitted',
                                'maintenance_request_status_code' => '1'));

        DB::table('maintenance_request_status')->insert(array('maintenance_request_status_id' => '2',
                                    'maintenance_request_status_name' => 'Under Review',
                                    'maintenance_request_status_code' => '2'));

        DB::table('maintenance_request_status')->insert(array('maintenance_request_status_id' => '3',
                                    'maintenance_request_status_name' => 'Assigned',
                                    'maintenance_request_status_code' => '3'));
        DB::table('maintenance_request_status')->insert(array('maintenance_request_status_id' => '4',
                                    'maintenance_request_status_name' => 'Completed',
                                    'maintenance_request_status_code' => '4'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_request_status');
    }
}
