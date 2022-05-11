<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_pourcentage extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['pourceusd','pourcecdf','created_at'];
}
