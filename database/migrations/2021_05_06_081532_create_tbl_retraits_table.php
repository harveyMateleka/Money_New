<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRetraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_retraits', function (Blueprint $table) {
            $table->id();
            $table->string('matricule',10);
            $table->integer('numagence');
            $table->integer('id_depot');
            $table->timestamps();
            $table->foreign('id_depot')->references('id')->on('tbl_depots')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_retraits');
    }
}
