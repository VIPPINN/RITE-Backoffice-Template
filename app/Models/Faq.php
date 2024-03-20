<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = "PreguntaFrecuente";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'titulo',
      'texto',
      'orden',
      'estado' ,
      'fechaAlta',
      'fechaBaja'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}
