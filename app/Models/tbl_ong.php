<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_ong extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['name_ong','name_Perso','tel_contact','adresse_siege'];
}
