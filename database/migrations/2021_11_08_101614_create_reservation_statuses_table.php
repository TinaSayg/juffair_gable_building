<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('reservation_statuses', function (Blueprint $table) {
                $table->integer('reservation_statuses_id');
                $table->string('reservation_statuses_name');
                $table->integer('reservation_statuses_code');
            });

            // Insert Pre-populated Table Values
            DB::table('reservation_statuses')->insert(array('reservation_statuses_id' => '1',
                                                        'reservation_statuses_name' => 'Available',
                                                        'reservation_statuses_code' => '1'));
    
            DB::table('reservation_statuses')->insert(array('reservation_statuses_id' => '2',
                                                        'reservation_statuses_name' => 'Unavailable',
                                                        'reservation_statuses_code' => '2'));
    
            DB::table('reservation_statuses')->insert(array('reservation_statuses_id' => '3',
                                                        'reservation_statuses_name' => 'Reserved',
                                                        'reservation_statuses_code' => '3'));
    
            
        }
    
        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('reservation_statuses');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    