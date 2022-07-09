<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_years', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year');
            $table->date('seasonStartDate');
            $table->date('seasonEndDate');
            $table->integer('season_id')->unsigned();
            $table->timestamps();
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_years');
    }
}
