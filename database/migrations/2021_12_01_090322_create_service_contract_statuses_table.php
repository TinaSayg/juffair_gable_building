<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceContractStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_contract_statuses', function (Blueprint $table) {
            $table->integer('service_contract_status_id');
            $table->string('service_contract_status_name');
            $table->integer('service_contract_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('service_contract_statuses')->insert(array('service_contract_status_id' => '1',
                                'service_contract_status_name' => 'Opened',
                                'service_contract_status_code' => '1'));

        DB::table('service_contract_statuses')->insert(array('service_contract_status_id' => '2',
                                    'service_contract_status_name' => 'Closed',
                                    'service_contract_status_code' => '2'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_contract_statuses');
    }
}
