<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->integer('country_id');
            $table->string('country_name');
            $table->integer('country_code');
        });

        // Insert Pre-populated Table Values
        DB::table('countries')->insert(array('country_id' => '1',
                                         'country_name' => 'Bahrain',
                                         'country_code' => '1'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
