<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuestionarioVersion extends Model
{
    use HasFactory;

    protected $fillable = [
      'id', 
      'idCuestionario', 
      'descripcion', 
      'fechaAlta',
    ];

    /*public function user() 
    {
      return $this->belongsTo(User::class);
    } */
}
