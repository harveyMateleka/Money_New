<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class user extends Model implements Authenticatable
{
    use AuthenticableTrait;
    use HasFactory;
    public $timestamps=false;
    public $fillable=['matricule','id_users','email','password','etatcon','etat'];
}	


