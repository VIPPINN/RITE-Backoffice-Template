<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaEntidad extends Model
{
    use HasFactory;

    protected $fillable = [
      'id', 
      'orden', 
      'descripcion', 
    ];

    /*public function user() 
    {
      return $this->belongsTo(User::class);
    } */
}
