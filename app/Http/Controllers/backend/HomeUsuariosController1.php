<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeUsuariosController extends Controller
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
      $usuarios = DB::table('Usuario')
      ->join('TipoPersona','Usuario.idTipoPersona','=','TipoPersona.id')
      ->join('GrupoUsuario','Usuario.idGrupoUsuario','=','GrupoUsuario.id')
      ->select('Usuario.id as id',
               'nombre',
               'apellido',
               'CUIT',
               'email',
               'emailSecundario',
               'fechaAlta',
               'fechaBaja',
               'GrupoUsuario.descripcion as grupo')
      ->where('TipoPersona.id','=',1)
      ->paginate(10);

        //dd($usuarios);
		
      return view('backend.usuarios.index', [
        'usuarios' => $usuarios
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $grupos = DB::table('GrupoUsuario')->get();

      return view('backend.usuarios.create',['grupos' => $grupos]);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     $verificarMail = DB::table('Usuario')->where('email', $request->email)->first();

     
     if(!empty($verificarMail)){
      return redirect()->route('usuarios.create')
            ->with('error', 'Ya existe un usuario con ese mail.');
     }

     $verificarCuit = DB::table('Usuario')->where('CUIT', $request->cuit)->first();

     if(!empty($verificarCuit)){
      return redirect()->route('usuarios.create')
            ->with('error', 'Ya existe un usuario con ese CUIT.');
     }


      
      $data['nombre'] = $request->nombre;
      $data['apellido'] = $request->apellido;
      $data['email'] = $request->email;
      $data['emailSecundario'] = $request->email2;
      $data['CUIT'] = $request->cuit;
      $data['password'] = Hash::make($request->password);
      $data['idGrupoUsuario'] = $request->grupo;
      $data['idTipoPersona'] = 1;
      $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

      DB::table('Usuario')->insert($data);

      return redirect()->route('usuarios.index')
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
       $usuario = DB::table('Usuario')
       ->join('TipoPersona','Usuario.idTipoPersona','=','TipoPersona.id')
       ->join('GrupoUsuario','Usuario.idGrupoUsuario','=','GrupoUsuario.id')
       ->select('Usuario.id as id',
               'nombre',
               'apellido',
               'CUIT',
               'email',
               'emailSecundario',
               'fechaAlta',
               'fechaBaja',
               'GrupoUsuario.descripcion as grupo')->where('Usuario.id','=',$id)->first();
        
       return view('backend.usuarios.show',['usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = DB::table('Usuario')
        ->join('TipoPersona','Usuario.idTipoPersona','=','TipoPersona.id')
        ->join('GrupoUsuario','Usuario.idGrupoUsuario','=','GrupoUsuario.id')
        ->select('Usuario.id as id',
               'nombre',
               'apellido',
               'CUIT',
               'email',
               'emailSecundario',
               'fechaAlta',
               'fechaBaja',
               'GrupoUsuario.descripcion as grupo',
               'Usuario.idGrupoUsuario as grupoId')->where('Usuario.id','=',$id)->first();
        //dd($usuario);

        $grupos = DB::table('GrupoUsuario')->get();
        //dd($grupos);
        return view('backend.usuarios.edit',['usuario' => $usuario
                                              ,'grupos' => $grupos]);
       
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
      
    /*  dd($request);
     dd($id); */

     $data['nombre'] = $request->nombre;
     $data['apellido'] = $request->apellido;
     $data['CUIT'] = $request->cuit;
     $data['email'] = $request->email;
     $data['emailSecundario'] = $request->email2;
     $data['idGrupoUsuario'] = $request->grupo;

     DB::table('Usuario')
            ->where('id', $id)
            ->update($data);

     return redirect()->route('usuarios.index')
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
      
      DB::table('Usuario')->where('id', $id)->update($data);
      $element = DB::table('Usuario')->where('id', $id)->first();
      
      LogActivity::addToLog('Usuario - Dió de baja: '.$element->nombre);

      return redirect()->route('usuarios.index')
          ->with('success', 'El usuario se ha borrado con éxito');
    }
}
