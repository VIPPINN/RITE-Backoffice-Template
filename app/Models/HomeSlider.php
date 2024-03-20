<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HasFactory;

    protected $table = "Carrusel";

    protected $fillable = [
      'titulo', 
      'enlace', 
      'enlaceImagenPc',
      'color', 
      'orden',
      'estado',
      'fechaAlta',
      'fechaBaja'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}
