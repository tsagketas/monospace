<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselOpexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vessel_opexes', function (Blueprint $table) {
            $table->id('vessel_opex_id');
            $table->unsignedBigInteger('vessel_opex_vessel_id');
            $table->date('vessel_opex_date');
            $table->decimal('vessel_opex_expenses', 8, 2);
            $table->timestamps();

            $table->foreign('vessel_opex_vessel_id')->references('vessel_id')->on('vessels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vessel_opexes');
    }
}
