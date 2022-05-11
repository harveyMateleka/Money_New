<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_paiements', function (Blueprint $table) {
            $table->id();
            $table->integer('code_detail')->unsigned();
            $table->decimal('Montpay',15,2);
            $table->foreign('code_detail')->references('id')->on('tbl_detail_ts')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_paiements');
    }
}
