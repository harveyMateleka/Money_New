<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_vile extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['id_ville','ville','initial', 'dates'];
}
