<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_contracts', function (Blueprint $table) {
            $table->id();
            $table->Text('Title');
            $table->longText('description')->nullable();
            $table->decimal('amount', 15, 3);
            $table->string('frequency_of_pay');
            $table->string('image')->nullable();
            $table->integer('auto_renewal');
            $table->dateTime('contract_start_date')->nullable();
            $table->dateTime('contract_end_date')->nullable();
           
            $table->integer('service_contract_status_code');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_contracts');
    }
}
