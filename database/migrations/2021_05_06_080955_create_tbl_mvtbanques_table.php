<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMvtbanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_mvtbanques', function (Blueprint $table) {
            $table->id();
            $table->integer('id_type');
            $table->double('Montmvt',10,4);
            $table->string('matricule',10);
            $table->integer('id_banque')->unsigned();
            $table->string('agencesortie',50)->nullable()->change();
            $table->string('agenceentree',50)->nullable()->change();
            $table->text('observation');
            $table->foreign('matricule')->references('matricule')->on('tbl_personnels')->onDelete('cascade');
            $table->foreign('id_banque')->references('id_banq')->on('tbl_banques')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_mvtbanques');
    }
}
