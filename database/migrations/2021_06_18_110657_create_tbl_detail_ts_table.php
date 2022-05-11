<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblDetailTsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_detail_ts', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transf')->unsigned();
            $table->decimal('montp',15,2);
            $table->integer('numagence')->unsigned();
            $table->string('code_tr',8)->unique();
            $table->foreign('id_transf')->references('id')->on('tbl_transfert_ongs')->onDelete('cascade');
            $table->foreign('numagence')->references('numagence')->on('tbl_agences')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_detail_ts');
    }
}
