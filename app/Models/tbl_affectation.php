<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_affectation extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['	id','matricule','numagence','statut','created_at'];
}
