<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentPaidStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_paid_status', function (Blueprint $table) {
            $table->integer('rent_paid_status_id');
            $table->string('rent_paid_status_name');
            $table->integer('rent_paid_status_code');
        });

         // Insert Pre-populated Table Values
         DB::table('rent_paid_status')->insert(array('rent_paid_status_id' => '1',
                                        'rent_paid_status_name' => 'paid',
                                        'rent_paid_status_code' => '1'));

        DB::table('rent_paid_status')->insert(array('rent_paid_status_id' => '2',
                                        'rent_paid_status_name' => 'unpaid',
                                        'rent_paid_status_code' => '2'));
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_paid_status');
    }
}
