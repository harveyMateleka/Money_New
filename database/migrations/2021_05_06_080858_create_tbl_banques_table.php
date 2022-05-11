<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_banques', function (Blueprint $table) {
            $table->bigIncrements('id_banq');
            $table->string('numero_compte')->unique();
            $table->text('intitulecompte');
            $table->double('Montantcdf', 15, 4);
            $table->double('Montantusd', 15, 4);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_banques');
    }
}
