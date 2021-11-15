<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityBillTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_bill_types', function (Blueprint $table) {
            $table->integer('utility_bill_type_id');
            $table->string('utility_bill_type_name');
            $table->integer('utility_bill_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('utility_bill_types')->insert(array('utility_bill_type_id' => '1',
                                                'utility_bill_type_name' => 'Internet',
                                                'utility_bill_type_code' => '1'));

        DB::table('utility_bill_types')->insert(array('utility_bill_type_id' => '2',
                                                'utility_bill_type_name' => 'Ewa',
                                                'utility_bill_type_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utility_bill_types');
    }
}
