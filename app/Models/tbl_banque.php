<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_banque extends Model
{
    use HasFactory;
    public $timestamps=false;
    public $fillable=['id_banq','numero_compte','intitulecompte','Montant','devise'];
}
