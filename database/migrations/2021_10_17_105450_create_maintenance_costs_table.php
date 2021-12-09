<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_costs', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_title');
            $table->string('maintenance_description', 10000);
            $table->dateTime('maintenance_date');
            $table->integer('location_id');
            $table->integer('floor_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('common_area_id')->nullable();
            $table->integer('service_area_id')->nullable();
            $table->decimal('maintenance_cost_total_amount', 15, 3);
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
        Schema::dropIfExists('maintenance_costs');
    }
}
