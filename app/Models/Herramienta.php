<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;

    protected $table = "Herramienta";

    protected  $fillable = [
        'id', 
        'titulo', 
        'descripcion' ,
        'pdf' ,
        'excel' ,
        'linkVideo' ,
        'activo',
        'fechaAlta',
        'fechaBaja'
    ];

}
