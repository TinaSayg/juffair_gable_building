<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_types', function (Blueprint $table) {
            $table->integer('employee_type_id');
            $table->string('employee_type_name');
            $table->integer('employee_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('employee_types')->insert(array('employee_type_id' => '1',
                                                'employee_type_name' => 'Full Time',
                                                'employee_type_code' => '1'));

        DB::table('employee_types')->insert(array('employee_type_id' => '2',
                                                'employee_type_name' => 'Part Time',
                                                'employee_type_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_types');
    }
}
