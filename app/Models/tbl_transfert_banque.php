<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_transfert_banque extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['id_tranfert','numagence','id_partenaire','id_devise','montant','date_T','matricule', 'operation'];
}
