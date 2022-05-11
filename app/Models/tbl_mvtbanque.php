<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_mvtbanque extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['Montmvt','matricule','devise','id_banque','numagence','observation','etatmvt','prov_banq','prov_ag','created_at','updated_at','id_type','detail_prov','detail_des'];
}
