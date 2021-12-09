<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_request', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->dateTime('date')->nullable();
    	    $table->integer('location_id');
            $table->integer('floor_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('common_area_id')->nullable();
            $table->integer('service_area_id')->nullable();
            $table->integer('maintenance_request_status_code');
            $table->integer('user_id');

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
        Schema::dropIfExists('maintenance_request');
    }
}
