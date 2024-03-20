<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = "QueEsRite";

    protected  $fillable = [
        'id', 
        'titulo', 
        'descripcionLarga' ,
        'descripcionCorta' ,
        'enlacePdf' ,
        'estado' ,
        'fechaAlta',
        'fechaBaja'
    ];

}
