<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityDepositesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_deposites', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_first_name');
            $table->string('tenant_last_name');
            $table->string('tenant_email_address')->nullable();
            
            $table->decimal('security_deposite_total_amount', 15, 4);
            $table->enum('security_deposit_status',['paid','unpaid'])->default('unpaid');

            $table->integer('unit_id');
            $table->integer('floor_id');
            $table->integer('building_id');
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
        Schema::dropIfExists('security_deposites');
    }
}
