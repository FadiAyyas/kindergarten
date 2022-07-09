<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_phone_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['Static','Mother','Father'])->default('Father');
            $table->bigInteger('phoneNumber');
            $table->integer('parent_id')->unsigned();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parent_phone_numbers');
    }
}
