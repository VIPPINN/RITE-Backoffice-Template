<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TyCPDFs extends Model
{
    use HasFactory;
    protected $fillable=[
        'pdfNombre',
        'idTyC',
        'fechaAlta',
        'FechaBaja'
    ];
}
