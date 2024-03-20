<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = "Novedades";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'titulo',
      'slug',
      'descripcionLarga',
      'descripcionCorta',
      'fechaPublicacion',
      'orden',
      'imagenPublicacion',
      'estado' ,
      'fechaAlta',
      'fechaBaja'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}