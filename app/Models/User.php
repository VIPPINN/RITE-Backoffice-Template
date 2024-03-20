<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * GET the Sliders
     */
    public function homesliders() 
    {
      return $this->hasMany(HomeSlider::class);
    }

    /**
     * GET the What's rite?
     */
    public function abouts() 
    {
      return $this->hasMany(Rite::class);
    }

    /**
     * GET the videos
     */
    public function home_videos() 
    {
      return $this->hasMany(HomeVideo::class);
    }

    /**
     * GET the _News
     */
    public function news() 
    {
      return $this->hasMany(News::class);
    }

    /**
     * GET the FAQ
     */
    public function faqs() 
    {
      return $this->hasMany(Faq::class);
    }

    /**
     * GET the TipoRecurso
     */
    public function tipoRecursos() 
    {
      return $this->hasMany(TipoRecurso::class);
    }

    /**
     * GET the OrientadoRecurso
     */
    public function orientadoRecursos() 
    {
      return $this->hasMany(OrientadoRecurso::class);
    }

    /**
     * GET the OrigenRecurso
     */
    public function origenRecursos() 
    {
      return $this->hasMany(OrigenRecurso::class);
    }

    /**
     * GET the OrientadoRecurso
     */
    public function recursos() 
    {
      return $this->hasMany(Recurso::class);
    }

     /**
     * GET the Activity
     */
    public function activities() 
    {
      return $this->hasMany(LogActivity::class);
    }
}
