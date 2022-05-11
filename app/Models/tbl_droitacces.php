<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_droitacces extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['id_droit','id_fonction','id_sous'];
}
