<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('registrationDate');
            $table->integer('child_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('season_year_id')->unsigned();
            $table->timestamps();
            $table->foreign('child_id')->references('id')->on('childrens')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('Kgclasses')->onDelete('cascade');
            $table->foreign('season_year_id')->references('id')->on('season_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
