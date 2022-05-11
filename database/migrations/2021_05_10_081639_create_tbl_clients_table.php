<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_clients', function (Blueprint $table) {
            $table->bigIncrements("id_client");
            $table->string("nomclient",60);
            $table->string("tel",16)->unique();
            $table->string("email",30);
            $table->integer("id_type")->unsigned();
            $table->foreign('id_type')->references('id_type')->on('tbl_typeclients')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_clients');
    }
}
