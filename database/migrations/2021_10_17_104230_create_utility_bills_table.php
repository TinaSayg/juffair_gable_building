<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilityBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_bills', function (Blueprint $table) {
            $table->id();
            $table->string('utility_bill_description', 10000);
            $table->string('utility_bill_month');
            $table->string('utility_bill_year');
            $table->dateTime('utility_bill_date');
            
            $table->decimal('utility_bill_total_amount', 15, 3);
            
            $table->string('utility_bill_image');

            $table->integer('utility_bill_type_code');
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
        Schema::dropIfExists('utility_bills');
    }
}
