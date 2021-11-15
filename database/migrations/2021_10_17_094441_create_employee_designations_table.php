<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_designations', function (Blueprint $table) {
            $table->integer('employee_designation_id');
            $table->string('employee_designation_name');
            $table->integer('employee_designation_code');
        });

        // Insert Pre-populated Table Values
        DB::table('employee_designations')->insert(array('employee_designation_id' => '1',
                                            'employee_designation_name' => 'Admin',
                                            'employee_designation_code' => '1'));

        DB::table('employee_designations')->insert(array('employee_designation_id' => '2',
                                            'employee_designation_name' => 'General Manager',
                                            'employee_designation_code' => '2'));

        DB::table('employee_designations')->insert(array('employee_designation_id' => '3',
                                            'employee_designation_name' => 'Building Manager',
                                            'employee_designation_code' => '3'));

        DB::table('employee_designations')->insert(array('employee_designation_id' => '4',
                                            'employee_designation_name' => 'Security',
                                            'employee_designation_code' => '4'));

        DB::table('employee_designations')->insert(array('employee_designation_id' => '5',
                                            'employee_designation_name' => 'Accountant',
                                            'employee_designation_code' => '5'));

        DB::table('employee_designations')->insert(array('employee_designation_id' => '6',
                                            'employee_designation_name' => 'Receptionist',
                                            'employee_designation_code' => '6'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_designations');
    }
}
