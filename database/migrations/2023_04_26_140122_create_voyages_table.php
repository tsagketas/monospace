<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoyagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voyages', function (Blueprint $table) {
            $table->id('voyage_id');
            $table->unsignedBigInteger('voyage_vessel_id');
            $table->string('voyage_code');
            $table->dateTime('voyage_start');
            $table->dateTime('voyage_end')->nullable();
            $table->enum('voyage_status', ['pending', 'ongoing', 'submitted'])->default('pending');
            $table->decimal('voyage_revenues', 8, 2)->nullable();
            $table->decimal('voyage_expenses', 8, 2)->nullable();
            $table->decimal('voyage_profit', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('voyage_vessel_id')->references('vessel_id')->on('vessels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voyages');
    }
}
