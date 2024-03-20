<?php

namespace App\Helpers;
use Request;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\DB;


class LogActivity
{
    public static function addToLog($subject)
    {
    	$log = [];
        /*hay que ver lo del id null, pongo 1 par aque ande*/ 
        
    	$log['titulo']    = $subject;
    	$log['url']       = Request::fullUrl();
    	$log['metodo']    = Request::method();
    	$log['ip']        = Request::ip();
    	$log['agente']    = Request::header('user-agent');
        $log['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');
    	$log['idUser']    = auth()->check() ? auth()->user()->id : 1;
    	
      DB::table('LogDeActividad')->insert($log);
    }

    public static function logActivityLists()
    {
        $log = DB::table('LogDeActividad')
                    ->select('titulo','url','metodo','ip','agente','LogDeActividad.fechaAlta','Usuario.email as email')
                    ->join('Usuario', 'Usuario.id', '=', 'LogDeActividad.idUser')
                    ->orderBy('LogDeActividad.fechaAlta', 'desc')
                    ->paginate(10);

        return $log;
    }

}