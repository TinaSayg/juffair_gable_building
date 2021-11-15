<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_email_address')->nullable();
            $table->string('employee_mobile_phone');
            $table->dateTime('employee_date_of_birth');
            $table->string('employee_home_phone')->nullable();
            $table->string('employee_work_phone')->nullable();
            $table->string('employee_fax_phone')->nullable();
            
            $table->string('employee_present_address');
            $table->string('employee_permanent_address');
            $table->string('employee_city')->nullable();
            $table->integer('employee_province_id')->nullable();
            $table->integer('employee_country_id')->nullable();
            $table->string('employee_postal_code')->nullable();
            
            $table->string('employee_cpr_no');
            $table->dateTime('employee_start_datetime');
            $table->dateTime('employee_end_datetime')->nullable();
            $table->decimal('employee_sallery', 15, 3);

            $table->string('employee_image');
            $table->string('employee_passport_copy');
            $table->string('employee_cpr_copy');
            $table->string('employee_contract_copy');

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
        Schema::dropIfExists('employees');
    }
}
