<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSousMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sous_menus', function (Blueprint $table) {
            $table->increments("id_sous");
            $table->string("item_sous",50);
            $table->integer("id_menu")->unsigned();
            $table->foreign("id_menu")->references("id_menu")->on("tbl_menus")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_sous_menus');
    }
}
