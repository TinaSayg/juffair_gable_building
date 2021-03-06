<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->string('renter_name');

            $table->decimal('rent', 15, 3);
            $table->decimal('ewa_bill', 15, 3);
            $table->decimal('utility_bill', 15, 3);

            $table->dateTime('paid_date');
            $table->string('rent_month');
            $table->string('payment_method');

            $table->integer('unit_id');
            $table->integer('floor_id');
            $table->integer('building_id');
            $table->integer('rent_type_code');
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
        Schema::dropIfExists('rents');
    }
}
