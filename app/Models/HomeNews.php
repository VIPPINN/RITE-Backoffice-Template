<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeNews extends Model
{
    use HasFactory;

    protected $fillable = [
      'id', 
      'title', 
      'image', 
      'txt_short',  
      'txt_large',
      'status',
      'orden'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}
