<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeVideo extends Model
{
    use HasFactory;

    protected $table = "Video";

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'titulo',
      'enlace',
      'estado',
      'fechaAlta',
      'fechaBaja'
    ];
}
