<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dayes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        //
          Schema::create('dayes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day_id');
            $table->string('summary');
            $table->string('table');
            $table->text('data');
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
        //
         Schema::drop("dayes");
    }

}
