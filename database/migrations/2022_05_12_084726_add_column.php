<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_clients', function (Blueprint $table) {
            $table->string('postnom',50)->after("nomclient");
            $table->string('prenom',50)->after("postnom");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_clients', function (Blueprint $table) {
            $table->dropColumn('postnom');
            $table->dropColumn('prenom');
        });
    }
}
