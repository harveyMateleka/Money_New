<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_retrait extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['matricule','numagence','id_depot','date_servis'];
}
