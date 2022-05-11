<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_sous_menu extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['id_sous','item_sous','id_menu','lien'];
    
}
