<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('owner_first_name');
            $table->string('owner_last_name');
            $table->string('owner_email_address');
            $table->string('owner_mobile_phone');
            $table->string('owner_home_phone')->nullable();
            $table->string('owner_work_phone')->nullable();
            $table->string('owner_fax_phone')->nullable();
            $table->string('owner_image')->nullable();

            $table->string('owner_present_address');
            $table->string('owner_permanent_address');
            $table->string('owner_city')->nullable();
            $table->integer('owner_province_id')->nullable();
            $table->integer('owner_country_id')->nullable();
            $table->string('owner_postal_code')->nullable();
            
            $table->string('owner_cpr_no');

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
        Schema::dropIfExists('owners');
    }
}
