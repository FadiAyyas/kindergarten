<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateSeasonsTable extends Migration
{

    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('seasons_name');
            $table->timestamps();
        });

        $seasons=['First season','Second season','Third season','Fourth season'];
        foreach($seasons as $season)
        {
            DB::table('seasons')->insert([
             [ 'seasons_name' => $season,
               'created_at' =>now(),
               'updated_at' =>now()],
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasons');
    }
}
