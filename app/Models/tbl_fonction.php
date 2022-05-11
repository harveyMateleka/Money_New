<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_fonction extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['id_fonction','fonction'];
}
