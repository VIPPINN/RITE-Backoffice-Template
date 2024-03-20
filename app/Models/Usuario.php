<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;



//class Usuario extends Model
class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = "Usuario";
    protected $guard_name = 'web';

    protected $fillable = [
        'idUsuarioQueDelega', 
        'CUIT',
        'email',
        'idTipoPersona',
        'nombre',
        'apellido',
        'razonSocial',
        'idGrupoUsuario',
        'idClasificacionUltima'
    ];
}
