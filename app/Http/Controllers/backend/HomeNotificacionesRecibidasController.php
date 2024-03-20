<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeNotificacionesRecibidasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarioOA = DB::table('Usuario')->where('Usuario.nombre','OA')->first();
        $notificaciones = DB::table('Notificacion')
                    ->join('UsuarioNotificacion','Notificacion.id','=','UsuarioNotificacion.idNotificacion')
                    ->join('Usuario as u','Notificacion.idUsuarioEmisor','=','u.id')
                    ->leftJoin('Usuario as u2','u2.id','=','Notificacion.idEmpresaReportada')
                    ->select('Notificacion.asunto as asunto',
                             'Notificacion.notificacion as notificacion',
                             'Notificacion.notificacion as notificacion',
                             'Notificacion.fechaAlta as fechaAlta',
                             'Notificacion.fechaBaja as fechaBaja',
                             'Notificacion.adjunto as adjunto',
                             'u.nombre as nombre',
                             'u.apellido as apellido',
                             'u2.CUIT as CUIT',)
                    ->where('UsuarioNotificacion.idUsuario', $usuarioOA->id)
                    ->where('Notificacion.fechaBaja','=',NULL)
                    ->get();
     
        
        

        return view('backend.reportes.index',[
                        'notificaciones' => $notificaciones
        ]);

    }


  


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
     

    }


}
