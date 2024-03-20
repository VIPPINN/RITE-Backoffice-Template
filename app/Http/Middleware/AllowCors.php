<?php

namespace App\Http\Middleware;

use Closure;

class AllowCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'http://127.0.0.1:8000,https://www-test-rite.jus.gob.ar,https://www.rite.gob.ar/') // Cambia la URL a tu front-end
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    }
}

