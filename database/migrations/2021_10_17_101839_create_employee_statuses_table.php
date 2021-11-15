<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_statuses', function (Blueprint $table) {
            $table->integer('employee_status_id');
            $table->string('employee_status_name');
            $table->integer('employee_status_code');
        });

         // Insert Pre-populated Table Values
         DB::table('employee_statuses')->insert(array('employee_status_id' => '1',
                                            'employee_status_name' => 'Pending',
                                            'employee_status_code' => '1'));

        DB::table('employee_statuses')->insert(array('employee_status_id' => '2',
                                            'employee_status_name' => 'Active',
                                            'employee_status_code' => '2'));

        DB::table('employee_statuses')->insert(array('employee_status_id' => '3',
                                            'employee_status_name' => 'Inactive',
                                            'employee_status_code' => '3'));

        DB::table('employee_statuses')->insert(array('employee_status_id' => '4',
                                            'employee_status_name' => 'Suspended',
                                            'employee_status_code' => '4'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_statuses');
    }
}
