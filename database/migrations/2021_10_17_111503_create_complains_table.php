<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->string('complain_title');
            $table->string('complain_description',10000);
            $table->dateTime('complain_date');
            $table->integer('assigneed_id')->nullable();
            $table->integer('complain_person_id')->nullable();
            $table->integer('complain_status_code');
            $table->integer('complain_solution_id')->nullable();

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
        Schema::dropIfExists('complains');
    }
}
