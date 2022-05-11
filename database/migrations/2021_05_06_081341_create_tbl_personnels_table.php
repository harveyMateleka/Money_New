<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_personnels', function (Blueprint $table) {
            $table->string('matricule', 10)->primary();
            $table->string('nom',30);
            $table->string('postnom',30);
            $table->integer('id_fonction');
            $table->foreign('id_fonction')->references('id_fonction')->on('tbl_fonctions')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_personnels');
    }
}
