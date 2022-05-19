<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_client extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['id_client','nomclient','tel','postnom','prenom'];
}
