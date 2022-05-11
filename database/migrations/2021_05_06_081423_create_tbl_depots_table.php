<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_depots', function (Blueprint $table) {
            $table->id();
            $table->string('numdepot',10)->unique();
            $table->string('nomexpedit',50);
            $table->string('telclient',15)->unique();
            $table->text('nomben');
            $table->double('montenvoi',15,4);
            $table->double('montpour',8,4);
            $table->integer('etatservi');
            $table->string('matricule',10);
            $table->integer('id_ville');
            $table->integer('id_devise');
            $table->integer('numagence');
            $table->timestamps();
            $table->foreign('matricule')->references('matricule')->on('tbl_personnels')->onDelete('cascade');
            $table->foreign('id_ville')->references('id_ville')->on('tbl_viles')->onDelete('cascade');
            $table->foreign('id_devise')->references('id')->on('tbl_devises')->onDelete('cascade');
            $table->foreign('numagence')->references('numagence')->on('tbl_agences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_depots');
    }
}
