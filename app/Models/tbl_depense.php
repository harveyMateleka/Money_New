<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_depense extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['id_dep','motif','devise','etat','montant','id_auto','matricule','created_at','numagence','id_typdep'];
}
