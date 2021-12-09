<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_first_name');
            $table->string('tenant_last_name');
            $table->string('tenant_email_address');
            $table->string('tenant_mobile_phone');
            $table->dateTime('tenant_date_of_birth');
            $table->string('tenant_home_phone')->nullable();
            $table->string('tenant_work_phone')->nullable();
            $table->string('tenant_fax_phone')->nullable();
            $table->string('tenant_image');

            $table->string('tenant_present_address');
            $table->string('tenant_permanent_address');
            $table->string('home_country_address');

            $table->decimal('tenant_rent', 15, 3);
            $table->json('tenant_facilities_list')->nullable();
            $table->string('tenant_cpr_no');
            $table->dateTime('lease_period_start_datetime');
            $table->dateTime('lease_period_end_datetime');

            // $table->decimal('security_deposit', 15, 3)->nullable();

            $table->integer('rent_paid_status_code')->default(0);

            $table->string('emergancy_contact_number');
            $table->string('emergancy_email');

            $table->string('tenant_passport_copy');
            $table->string('tenant_cpr_copy');
            $table->string('tenant_contract_copy');

            $table->string('password');
            $table->integer('unit_id');
            $table->integer('floor_id');
           
            $table->integer('tenant_type_code');

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
        Schema::dropIfExists('tenants');
    }
}
