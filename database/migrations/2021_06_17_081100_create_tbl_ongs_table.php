<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ongs', function (Blueprint $table) {
            $table->id();
            $table->string('name_ong',50);
            $table->string('name_Perso',50);
            $table->string('tel_contact',15)->unique();
            $table->string('adresse_siege',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_ongs');
    }
}
