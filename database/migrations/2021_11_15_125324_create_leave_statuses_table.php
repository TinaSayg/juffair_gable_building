<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_statuses', function (Blueprint $table) {
            $table->integer('leave_status_id');
            $table->string('leave_status_name');
            $table->integer('leave_status_code');
        });
        DB::table('leave_statuses')->insert(array('leave_status_id' => '1',
        'leave_status_name' => 'Approved',
        'leave_status_code' => '1'));

        DB::table('leave_statuses')->insert(array('leave_status_id' => '2',
                'leave_status_name' => 'Pending',
                'leave_status_code' => '2'));

        DB::table('leave_statuses')->insert(array('leave_status_id' => '3',
                'leave_status_name' => 'Disapproved',
                'leave_status_code' => '3'));
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_statuses');
    }
}
