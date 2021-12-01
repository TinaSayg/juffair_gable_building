<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->dateTime('leave_start_date');
            $table->dateTime('leave_end_date');
            $table->dateTime('apply_date');
            $table->longText('leave_reason');
            $table->integer('leave_status_code');
            $table->integer('leave_type_code');
            $table->string('leave_document');
            $table->Integer('staff_id');

            $table->Integer('leaves_taken')->nullable();
            $table->string('leaves_taken_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_leaves');
    }
}
