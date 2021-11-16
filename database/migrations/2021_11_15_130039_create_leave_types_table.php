<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->integer('leave_type_id');
            $table->string('leave_type_name');
            $table->integer('leave_type_code');
        });
        DB::table('leave_types')->insert(array('leave_type_id' => '1',
        'leave_type_name' => 'Medical Leave',
        'leave_type_code' => '1'));

        DB::table('leave_types')->insert(array('leave_type_id' => '2',
                'leave_type_name' => 'Vacation Leave',
                'leave_type_code' => '2'));
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_types');
    }
}
