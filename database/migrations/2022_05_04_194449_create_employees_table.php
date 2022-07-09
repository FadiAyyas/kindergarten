<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->text('photo');
            $table->bigInteger('phoneNumber');
            $table->enum('gender', ['ذكر', 'انثى']);
            $table->string('address');
            $table->enum('role', ['مدير', 'معلم','مشرف باص'])->default('مدير');
            $table->integer('age');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        DB::table('employees')->insert([
            ['id' => 1,
            'firstName' => 'admin',
            'lastName' => 'admin',
            'photo' => '',
            'phoneNumber' => '0999999999',
            'gender' => 'ذكر',
            'address' => 'Syria',
            'role' => 'مدير',
            'age' => '45',
            'email' => 'Admin_Super@Kg.sy',
            'password' => Hash::make('123456'),
            'created_at' => now()],
        ]);
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
