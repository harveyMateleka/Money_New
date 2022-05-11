<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_transfert_ong extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['id_ong','mont_trans','mont_com','mont_dep','devise','type','prov','destri','taux','montpayé','created_at'];
}
