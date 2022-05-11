<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_agence extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['numagence','nomagence','adresse','telservice','id_ville','Montcdf','Montusd','initial'];
}
