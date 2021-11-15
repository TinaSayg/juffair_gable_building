<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('building_name');
            $table->longText('description');
            
            $table->string('building_address_line_1');
            $table->text('building_business_number')->nullable();
            $table->string('building_address_line_2')->nullable();
            $table->integer('building_city_id')->nullable();
            $table->integer('building_country_id')->nullable();
            $table->string('building_postal_code')->nullable();
            $table->string('building_comments', 10000)->nullable();


            // $table->integer('building_type_code');
            $table->string('image')->nullable();
            $table->integer('owner_id');
            // $table->integer('building_status_code');

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
        Schema::dropIfExists('buildings');
    }
}
