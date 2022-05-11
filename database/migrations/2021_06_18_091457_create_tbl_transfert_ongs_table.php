<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTransfertOngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transfert_ongs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ong')->unsigned();
            $table->decimal('mont_trans',15,2);
            $table->decimal('mont_com',10,2);
            $table->decimal('mont_dep',10,2);
            $table->string('devise',1);
            $table->string('type',1);
            $table->integer('prov');
            $table->string('destri',50);
            $table->string('taux',5);
            $table->decimal('montpayé',15,2);
            $table->foreign('id_ong')->references('id')->on('tbl_ongs')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_transfert_ongs');
    }
}
