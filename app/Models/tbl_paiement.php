<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_paiement extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['code_detail','Montpay','created_at'];
}
