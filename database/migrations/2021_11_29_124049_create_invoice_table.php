<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('renter_name');
            $table->string('apartment_no');
            $table->string('invoice_no');
            $table->decimal('rent', 15, 3);
            $table->decimal('ewa_bill', 15, 3);
            $table->decimal('utility_bill', 15, 3);
            $table->dateTime('date_of_issue');
            $table->dateTime('paid_date');
            $table->string('payment_method');
            $table->string('note');
            $table->integer('rent_paid_status_code');
            $table->decimal('grand_total', 15, 3);
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
        Schema::dropIfExists('invoice');
    }
}
