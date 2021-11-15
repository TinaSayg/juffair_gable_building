<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_types', function (Blueprint $table) {
            $table->integer('tenant_type_id');
            $table->string('tenant_type_name');
            $table->integer('tenant_type_code');
        });

        // Insert Pre-populated Table Values
        DB::table('tenant_types')->insert(array('tenant_type_id' => '1',
                                             'tenant_type_name' => 'Individual',
                                             'tenant_type_code' => '1'));

        DB::table('tenant_types')->insert(array('tenant_type_id' => '2',
                                             'tenant_type_name' => 'Corporation',
                                             'tenant_type_code' => '2'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_types');
    }
}
