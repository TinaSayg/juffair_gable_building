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
            $table->integer('earned_leaves');
            $table->integer('leaves_taken');
            $table->integer('leave_status_code');
            $table->integer('leave_type_code');
            $table->Integer('staff_id');
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
