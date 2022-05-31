<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_depot extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['numdepot','telclient','nomben','montenvoi','montpour','etatservi','matricule','id_ville','id_devise',
                      'numagence','created_at','id_client'];
}
