<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_historique extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['matricule','operation','created_at'];
}
