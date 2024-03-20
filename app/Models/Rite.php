<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rite extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'title',
      'txt_short',
      'txt_large',
      'link_pdf',
      'status'
    ];

    public function user() 
    {
      return $this->belongsTo(User::class);
    }
}