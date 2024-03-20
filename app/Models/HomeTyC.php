<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeTyC extends Model
{
    use HasFactory;

    protected $fillable = [
      'id', 
      'titulo', 
      'texto1', 
      'texto2',  
      'texto3'
    ];

   
}
