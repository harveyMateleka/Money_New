<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_depenses', function (Blueprint $table) {
            $table->bigIncrements("id_dep");
            $table->text("motif");
            $table->string("dev",3);
            $table->string("etat",1);
            $table->decimal("montant",10,4);
            $table->integer("id_typdep")->unsigned();
            $table->integer("id_auto")->unsigned();
            $table->string('matricule',10);
            $table->timestamps();
            $table->foreign("matricule")->references("matricule")->on("tbl_personnels")->onDelete('cascade');
            $table->foreign("id_typdep")->references("id_typdep")->on("tbl_typedepenses")->onDelete('cascade');
            $table->foreign("id_auto")->references("id_auto")->on("tbl_autorisations")->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_depenses');
    }
}
