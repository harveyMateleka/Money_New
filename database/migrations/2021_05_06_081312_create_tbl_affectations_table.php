<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAffectationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_affectations', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->integer('numagence');
            $table->timestamps();
            $table->foreign('matricule')->references('matricule')->on('tbl_personnels')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_affectations');
    }
}
