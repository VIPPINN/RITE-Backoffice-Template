<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//Tabla intermedia que relaciona recurso con orientacion

//filtros
use Mehradsadeghi\FilterQueryString\FilterQueryString;
class orientado_recursos extends Model
{
    use HasFactory;
    use FilterQueryString;

    

}
