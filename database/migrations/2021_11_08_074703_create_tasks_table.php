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

            $table->dateTime('assign_date');
            $table->string('assign_time');

            $table->dateTime('complete_date')->nullable();
            $table->dateTime('complete_time')->nullable();

            $table->integer('assignor_id');
            $table->integer('assignee_id');
            $table->integer('task_status_code');

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
