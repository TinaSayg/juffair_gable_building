<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_statuses', function (Blueprint $table) {
            $table->integer('room_status_id');
            $table->string('room_status_name');
            $table->integer('room_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('room_statuses')->insert(array('room_status_id' => '1',
                                                    'room_status_name' => 'Available',
                                                    'room_status_code' => '1'));

        DB::table('room_statuses')->insert(array('room_status_id' => '2',
                                                    'room_status_name' => 'Unavailable',
                                                    'room_status_code' => '2'));

        DB::table('room_statuses')->insert(array('room_status_id' => '3',
                                                    'room_status_name' => 'Reserved',
                                                    'room_status_code' => '3'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_statuses');
    }
}
