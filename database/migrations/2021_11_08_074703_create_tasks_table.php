<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('comments', 500)->nullable();
            $table->dateTime('assign_date')->nullable();
            $table->string('assign_time')->nullable();
            $table->dateTime('deadline_date')->nullable();
            $table->string('deadline_time')->nullable();
            $table->dateTime('complete_date')->nullable();
            $table->string('complete_time')->nullable();
            $table->integer('assignor_id')->nullable();
            $table->integer('assignee_id')->nullable();
            $table->integer('location_id');
            $table->integer('floor_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('common_area_id')->nullable();
            $table->integer('service_area_id')->nullable();
            $table->integer('task_status_code')->nullable();

            $table->integer('user_id')->nullable();
            $table->integer('maintenance_request_id')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
