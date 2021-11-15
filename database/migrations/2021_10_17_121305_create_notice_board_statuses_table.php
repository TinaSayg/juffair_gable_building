<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeBoardStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_board_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('notice_board_status_id');
            $table->string('notice_boardstatus_name');
            $table->integer('notice_boardstatus_code');
            $table->timestamps();
        });

        // Insert Pre-populated Table Values
        DB::table('notice_board_statuses')->insert(array('notice_board_status_id' => '1',
                                                    'notice_boardstatus_name' => 'Active',
                                                    'notice_boardstatus_code' => '1'));

        DB::table('notice_board_statuses')->insert(array('notice_board_status_id' => '2',
                                                    'notice_boardstatus_name' => 'Inactive',
                                                    'notice_boardstatus_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notice_board_statuses');
    }
}
