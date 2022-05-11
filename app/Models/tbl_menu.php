<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_menu extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['id_menu','item_menu','icon'];
}
