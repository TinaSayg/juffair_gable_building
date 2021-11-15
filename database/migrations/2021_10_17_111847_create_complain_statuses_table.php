<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complain_statuses', function (Blueprint $table) {
            $table->integer('complain_status_id');
            $table->string('complain_status_name');
            $table->integer('complain_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('complain_statuses')->insert(array('complain_status_id' => '1',
                                                    'complain_status_name' => 'Pending',
                                                    'complain_status_code' => '1'));

        DB::table('complain_statuses')->insert(array('complain_status_id' => '2',
                                                    'complain_status_name' => 'In Progress',
                                                    'complain_status_code' => '2'));

        DB::table('complain_statuses')->insert(array('complain_status_id' => '3',
                                                    'complain_status_name' => 'On hold',
                                                    'complain_status_code' => '3'));

        DB::table('complain_statuses')->insert(array('complain_status_id' => '4',
                                                    'complain_status_name' => 'Completed',
                                                    'complain_status_code' => '4'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complain_statuses');
    }
}
