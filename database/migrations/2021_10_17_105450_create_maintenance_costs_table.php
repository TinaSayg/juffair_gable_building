<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_costs', function (Blueprint $table) {
            $table->id();
            $table->string('maintenance_title');
            $table->string('maintenance_description', 10000);
            $table->dateTime('maintenance_date');
            $table->decimal('maintenance_cost_total_amount', 15, 4);
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
        Schema::dropIfExists('maintenance_costs');
    }
}
