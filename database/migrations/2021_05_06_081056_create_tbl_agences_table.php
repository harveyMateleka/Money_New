<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAgencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agences', function (Blueprint $table) {
            $table->bigIncrements('numagence');
            $table->string('nomagence',50);
            $table->string('adresse',50);
            $table->string('telservice',15)->unique();
            $table->integer('id_ville')->unsigned();
            $table->double('Montcdf',10,4);
            $table->double('Montusd',7,4);
            $table->foreign('id_ville')->references('id_ville')->on('tbl_viles')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_agences');
    }
}
