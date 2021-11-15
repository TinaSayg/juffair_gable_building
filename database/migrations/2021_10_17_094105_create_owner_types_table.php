<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_types', function (Blueprint $table) {
            $table->integer('owner_type_id');
            $table->string('owner_type_name');
            $table->integer('owner_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('owner_types')->insert(array('owner_type_id' => '1',
                                            'owner_type_name' => 'Owner (Individual)',
                                            'owner_type_code' => '1'));

        DB::table('owner_types')->insert(array('owner_type_id' => '2',
                                            'owner_type_name' => 'Owner (Corporation)',
                                            'owner_type_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_types');
    }
}
