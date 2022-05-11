<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_personnel extends Model
{
    use HasFactory;
    public $timestamps=false;
	public $fillable=['matricule','nom','postnom','prenom','adresse','tel','etat','id_fonction','occupation'];
}
