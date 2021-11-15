<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_statuses', function (Blueprint $table) {
            $table->integer('tenant_status_id');
            $table->string('tenant_status_name');
            $table->integer('tenant_status_code');
        });

        // Insert Pre-populated Table Values
        DB::table('tenant_statuses')->insert(array('tenant_status_id' => '1',
                                            'tenant_status_name' => 'Pending',
                                            'tenant_status_code' => '1'));

        DB::table('tenant_statuses')->insert(array('tenant_status_id' => '2',
                                            'tenant_status_name' => 'Active',
                                            'tenant_status_code' => '2'));

        DB::table('tenant_statuses')->insert(array('tenant_status_id' => '3',
                                            'tenant_status_name' => 'Inactive',
                                            'tenant_status_code' => '3'));

        DB::table('tenant_statuses')->insert(array('tenant_status_id' => '4',
                                            'tenant_status_name' => 'Suspended',
                                            'tenant_status_code' => '4'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_statuses');
    }
}
