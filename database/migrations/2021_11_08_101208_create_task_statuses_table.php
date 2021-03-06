<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->integer('task_status_id');
            $table->string('task_status_name');
            $table->integer('task_status_code');
        });

         // Insert Pre-populated Table Values
         DB::table('task_statuses')->insert(array('task_status_id' => '1',
         'task_status_name' => 'Pending',
         'task_status_code' => '1'));

         DB::table('task_statuses')->insert(array('task_status_id' => '2',
                'task_status_name' => 'Completed',
                'task_status_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_statuses');
    }
}
