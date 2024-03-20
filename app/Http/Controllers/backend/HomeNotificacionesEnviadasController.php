<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeNotificacionesEnviadasController extends Controller
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
        $noticias = DB::table('NotificacionTipo')->where('descripcion','LIKE','%Noticia%')->first();
        $noticiaId = $noticias->id;
        $notificaciones = DB::table('Notificacion')
                        ->join('NotificacionTipo','NotificacionTipo.id','=','Notificacion.idNotificacionTipo')
                        ->select('Notificacion.id as id',
                                 'Notificacion.asunto as asunto',
                                  'Notificacion.notificacion as notificacion',
                                  'Notificacion.fechaAlta as fechaAlta',
                                  'Notificacion.fechaBaja as fechaBaja',
                                  'Notificacion.idUsuarioEmisor as idUsuarioEmisor',
                                  'NotificacionTipo.descripcion as descripcion')
                        ->where('NotificacionTipo.id','=',$noticiaId)
                        ->get();
        
         if(!$notificaciones->isEmpty()){
            foreach ($notificaciones as $key => $value) {
                $destinos[$value->id] = DB::table('UsuarioNotificacion')->join('Usuario','Usuario.id','=','UsuarioNotificacion.idUsuario')->where('UsuarioNotificacion.idNotificacion','=',$value->id)->get();
            }
            
         }else{
            $destinos = "";
         }           
         
     

        return view('backend.notificaciones.index',[
                                'notificaciones' => $notificaciones,
                                'destinos' => $destinos
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //saco Pedido Debida Diligencia de los tipos de notificaciones enviadas por backoffice
      $tipos = DB::table('NotificacionTipo')->where('descripcion','NOT LIKE','%Diligencia%')->get();
      $tipoPrueba = DB::table('GrupoUsuario')->where('descripcion','LIKE','%Prueba%')->first();
      $tipoPruebaId =  $tipoPrueba->id;
      $usuarios = DB::table('Usuario')->where('idTipoPersona','=',2)->where('fechaBaja',NULL)->where('idGrupoUsuario','!=',$tipoPruebaId)->get();
    

      return view('backend.notificaciones.create',[
        'tipos' => $tipos,
        'usuarios' => $usuarios
        ]);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
            if($request->destinatario == "Todos"){
                $todos = DB::table('Usuario')->select('id')->where('idTipopersona',1)->get();
                $bool = true;
                foreach($todos as $index3 => $usuario){
                    $usuariosDestino[] = $usuario->id;
                }
                
            }else{
                //Agregue CUIT para poder buscar por CUIT o razonSocial
                //tengo que agarrar solo la razonSocial para hacer busqueda de delegados
                $destinatario = explode('- ',$request->destinatario);
                $bool = false;
                $usuariosDelegadosDestino = DB::table('Usuario')
                        ->join('UsuarioDelegado','UsuarioDelegado.idUsuarioQueDelega','=','Usuario.id')
                        ->select('UsuarioDelegado.idUsuarioDelegado')
                        ->where('Usuario.razonSocial',$destinatario[1])
                        ->where('UsuarioDelegado.fechaBaja',NULL)
                        ->get();
                     
                foreach ($usuariosDelegadosDestino as $key => $value) {
                    $usuariosDestino[] = $value; 
                }
               
                
            }

        

            $usuarioOA = DB::table('Usuario')->where('Usuario.nombre','OA')->first(); 

    
    $data['notificacion'] = $request->mensaje;
    $data['asunto'] = $request->asunto; 
    $data['idNotificacionTipo'] = $request->tipo;
    $data['fechaAlta'] = $request->alta;
    $data['idUsuarioEmisor'] = $usuarioOA->id;
    $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');
     
    DB::table('Notificacion')->insert($data);
    
    $ultimaNotificacion = DB::table('Notificacion')->orderBy('fechaAlta','desc')->first();

    
    if($bool){
        
        foreach ($usuariosDestino as $index2 => $usuarioDestino){
            $dataDestino['idUsuario'] = $usuarioDestino;
            $dataDestino['idNotificacion'] = $ultimaNotificacion->id;
            
            DB::table('UsuarioNotificacion')->insert($dataDestino);
    }
    }else{
        foreach ($usuariosDestino as $index2 => $usuarioDestino){
           
            $dataDestino['idUsuario'] = $usuarioDestino->idUsuarioDelegado;
            $dataDestino['idNotificacion'] = $ultimaNotificacion->id;
            
            DB::table('UsuarioNotificacion')->insert($dataDestino);
        }
    }
    
    
    return redirect()->route('notificacionEnviada.index')
    ->with('success', 'El usuario fue creado satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $notificacion = DB::table('Notificacion')
        ->join('NotificacionTipo','NotificacionTipo.id','=','Notificacion.idNotificacionTipo')
        ->where('Notificacion.id','=',$id)
        ->first();

        $destinos = DB::table('UsuarioNotificacion')->join('Usuario','Usuario.id','=','UsuarioNotificacion.idUsuario')->where('UsuarioNotificacion.idNotificacion','=', $id)->get();



return view('backend.notificaciones.show',[
                'notificacion' => $notificacion,
                'destinos' => $destinos
]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $notificacion = DB::table('Notificacion')
        ->join('NotificacionTipo','NotificacionTipo.id','=','Notificacion.idNotificacionTipo')
        ->select('Notificacion.id as id',
                                 'Notificacion.asunto as asunto',
                                  'Notificacion.notificacion as notificacion',
                                  'Notificacion.fechaAlta as fechaAlta',
                                  'Notificacion.fechaBaja as fechaBaja',
                                  'Notificacion.idUsuarioEmisor as idUsuarioEmisor',
                                  'NotificacionTipo.descripcion as descripcion')
        ->where('Notificacion.id','=',$id)
        ->first();

       

        $destinos = DB::table('UsuarioNotificacion')->join('Usuario','Usuario.id','=','UsuarioNotificacion.idUsuario')->where('UsuarioNotificacion.idNotificacion','=', $id)->get();


        $tipoNotificaciones = DB::table('NotificacionTipo')->get();

        $usuarios = DB::table('Usuario')->where('idTipoPersona','=',1)->get();
        
        return view('backend.notificaciones.edit',[
                'notificacion' => $notificacion,
                'destinos' => $destinos,
                'tipoNotificaciones' => $tipoNotificaciones,
                'usuarios' => $usuarios
    ]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        
        $request->validate([
            'asunto' => 'required',
            'mensaje' => 'required',
            'destinatarios' => 'required',
            'tipo' => 'required',
           
          ],
          [
            'titulo.required' => '(*) El titulo es requerido. Debe ingresarla.',
            'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
            'destinatarios[].required' => '(*) Los destinatarios son requeridos. Debe ingresarlo.',
            'tipo.required' => '(*) El tipo de herramienta es requerido. Debe ingresarlo.',
           
          ]);

          
        $data['notificacion'] = $request->mensaje;
        $data['asunto'] = $request->asunto; 
        $data['idNotificacionTipo'] = $request->tipo;
        $data['idUsuarioEmisor'] = 11;
    
     
        DB::table('Notificacion')->where('id', $id)->update($data);

        DB::table('UsuarioNotificacion')->where('idNotificacion','=',$id)->delete();
        
        foreach ($request->destinatarios as $index => $destinatario){
            if($destinatario == 0){
                $todos = DB::table('Usuario')->select('id')->where('idTipopersona',1)->get();

                foreach($todos as $index3 => $usuario){
                    $usuariosDestino[] = $usuario->id;
                }
                
            }else{
                $usuariosDestino[] = $destinatario; 
            }

        }

        foreach ($usuariosDestino as $index2 => $usuarioDestino){
            $dataDestino['idUsuario'] = $usuarioDestino;
            $dataDestino['idNotificacion'] = $id;
            
            DB::table('UsuarioNotificacion')->insert($dataDestino);
    }
    
       

        return redirect()->route('notificacionEnviada.index')
        ->with('success', 'El usuario fue editado exitosamente.');
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
      
        DB::table('Notificacion')->where('id', $id)->update($data);
        $element = DB::table('Notificacion')->where('id', $id)->first();
        
        LogActivity::addToLog('Notificacion - Dió de baja: '.$element->asunto);
  
        return redirect()->route('notificacionEnviada.index')
            ->with('success', 'La Notificacion se ha borrado con éxito');
     
    }
}
