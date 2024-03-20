<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//filtros
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class Recurso extends Model
{
    use HasFactory;
    use FilterQueryString;

    protected $table = "recursos";

    protected $filters = ['titulo','idTipoRecurso','idOrigenRecurso','in','orientadoId','idTemaRecurso'];

   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'descargaLink',
        'status',
        'user_id',
        'idTipoRecurso',
        'idOrigenRecurso',
        'idTemaRecurso'

      ];
  
      public function user() 
      {
        return $this->belongsTo(User::class);
      }

      public function tipoRecurso()
      {
        return $this->hasOne(TipoRecurso::class);
      }
      public function orientadoRecurso()
      {
        return $this->belongsToMany(OrientadoRecurso::class);
      }
      public function origenRecurso()
      {
        return $this->hasOne(OrigenRecurso::class);
      }

      public function temaRecurso()
      {
        return $this->hasOne(Tema::class);
      }
}
