<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = "LogDeActividad";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'titulo',
      'url',
      'metodo',
      'ip',
      'agente',
      'fechaAlta',
      'idUser'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}
