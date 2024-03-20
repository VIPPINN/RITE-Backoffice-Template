<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeRedes extends Model
{
    use HasFactory;

    protected $table = "RedSocial";

    protected $fillable = [
      'titulo', 
      'enlace', 
      'logotipo',
      'estado' ,
      'fechaAlta',
      'fechaBaja'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}
