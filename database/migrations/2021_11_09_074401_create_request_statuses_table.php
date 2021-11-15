<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_statuses', function (Blueprint $table) {
            $table->integer('request_status_id');
            $table->string('request_status_name');
            $table->integer('request_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('request_statuses')->insert(array('request_status_id' => '1',
                                'request_status_name' => 'Pending',
                                'request_status_code' => '1'));

        DB::table('request_statuses')->insert(array('request_status_id' => '2',
                                    'request_status_name' => 'Accepted',
                                    'request_status_code' => '2'));

        DB::table('request_statuses')->insert(array('request_status_id' => '3',
                                    'request_status_name' => 'Rejected',
                                    'request_status_code' => '3'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_statuses');
    }
}
