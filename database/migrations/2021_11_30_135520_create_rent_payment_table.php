<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('rent_id');
            $table->decimal('paid_amount', 15, 3);
            $table->string('payment_type');
            $table->dateTime('payment_date');
            $table->string('payment_method');
            $table->integer('payment_status');
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
        Schema::dropIfExists('rent_payment');
    }
}
