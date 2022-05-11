<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_detail_t extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['created_at','code_tr','numagence','montp','id_transf'];
}
