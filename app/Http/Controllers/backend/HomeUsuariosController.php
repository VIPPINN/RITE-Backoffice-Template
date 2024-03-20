<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Models\Usuario;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Services\FiltroService;

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
  public function filtro($estado)
  {

    if (!is_numeric($estado)) return abort(404);

    $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Usuario Simulacion%')->first();
    $idGrupoSimulacion = $grupoSimulacion->id;

    if ($estado == 1) {
      $usuarios = DB::table('Usuario')
        ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
        ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
        ->select(
          'Usuario.id as id',
          'nombre',
          'apellido',
          'CUIT',
          'email',
          'emailSecundario',
          'fechaAlta',
          'fechaBaja',
          'GrupoUsuario.descripcion as grupo'
        )
        ->where('TipoPersona.id', '=', 1)
        ->where('fechaBaja', NULL)
        ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
        ->get();

      foreach ($usuarios as $usuario) {
        $usuario->roles = DB::table('model_has_roles')
          ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
          ->where('model_has_roles.model_id', $usuario->id)
          ->pluck('roles.name')
          ->toArray();
      }
    }
    if ($estado == 0) {
      $usuarios = DB::table('Usuario')
        ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
        ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
        ->select(
          'Usuario.id as id',
          'nombre',
          'apellido',
          'CUIT',
          'email',
          'emailSecundario',
          'fechaAlta',
          'fechaBaja',
          'GrupoUsuario.descripcion as grupo'
        )
        ->where('TipoPersona.id', '=', 1)
        ->where('fechaBaja', '!=', NULL)
        ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
        ->get();

      foreach ($usuarios as $usuario) {
        $usuario->roles = DB::table('model_has_roles')
          ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
          ->where('model_has_roles.model_id', $usuario->id)
          ->pluck('roles.name')
          ->toArray();
      }
    }
    if ($estado == 9) {
      $usuarios = DB::table('Usuario')
        ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
        ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
        ->select(
          'Usuario.id as id',
          'nombre',
          'apellido',
          'CUIT',
          'email',
          'emailSecundario',
          'fechaAlta',
          'fechaBaja',
          'GrupoUsuario.descripcion as grupo'
        )
        ->where('TipoPersona.id', '=', 1)
        ->get();

      foreach ($usuarios as $usuario) {
        $usuario->roles = DB::table('model_has_roles')
          ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
          ->where('model_has_roles.model_id', $usuario->id)
          ->pluck('roles.name')
          ->toArray();
      }
    }

    return view('backend.usuarios.index', [
      'usuarios' => $usuarios
    ]);
  }
  public function index()
  {
    $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Usuario Simulacion%')->first();
    $idGrupoSimulacion = $grupoSimulacion->id;

    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'GrupoUsuario.descripcion as grupo'
      )
      ->where('TipoPersona.id', '=', 1)
      ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
      ->get();

    foreach ($usuarios as $usuario) {
      $usuario->roles = DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('model_has_roles.model_id', $usuario->id)
        ->pluck('roles.name')
        ->toArray();
    }


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

    $roles = Role::all();

    return view('backend.usuarios.create', ['grupos' => $grupos, 'roles' => $roles]);
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'roles' => 'required',
      'email' => 'required',
      'cuit' => 'required',
      'password' => 'required',
    ]);

    if (empty($request->input('roles'))) {
      return redirect()->route('usuarios.create')
        ->with('error', 'Debe asignar un rol al usuario.');
    }

    $verificarMail = DB::table('Usuario')->where('email', $request->email)->first();


    if (!empty($verificarMail)) {
      return redirect()->route('usuarios.create')
        ->with('error', 'Ya existe un usuario con ese mail.');
    }

    $verificarCuit = DB::table('Usuario')->where('CUIT', $request->cuit)->where('idTipoPersona', 1)->where('fechaBaja', NULL)->first();

    if (!empty($verificarCuit)) {
      return redirect()->route('usuarios.create')
        ->with('error', 'Ya existe un usuario con ese CUIT.');
    }

    $grupoAutorizado = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Autorizado%')->first();


    $grupoDelegado = DB::table('GrupoUsuario')->where('descripcion', 'Delegado')->first();
    $idGrupoDelegado = $grupoDelegado->id;
    $data['nombre'] = $request->nombre;
    $data['apellido'] = $request->apellido;
    $data['email'] = $request->email;
    $data['emailSecundario'] = $request->email2;
    $data['CUIT'] = $request->cuit;
    $data['password'] = Hash::make($request->password);
    $data['idGrupoUsuario'] = $idGrupoDelegado;
    $data['idTipoPersona'] = 1;
    $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

    //Log de creacion
    LogActivity::addToLog('Usuario Creado:' . $data["email"]);

    $userId = DB::table('Usuario')->insertGetId($data);

    $usuarioPersona = DB::table('Usuario')->where('email', $request->email)->first();

    //obtengo el usuario agregado
    $user = Usuario::find($userId);

    // Obtener los roles seleccionados desde la solicitud
    $roles = $request->input('roles');

    // Asignar los roles al usuario
    $user->assignRole($roles);
    /*  } */

    $cuestionarios = DB::table('Cuestionario')->where('fechaBaja', null)->get();


    foreach ($cuestionarios as $index => $cuestionario) {
      $datatyc['idUsuario']        = $usuarioPersona->id;
      $datatyc['idCuestionario']   = $cuestionario->id;
      $datatyc['estadoTyC']        = 0;
      $datatyc['fechaAlta']        = DB::raw('CURRENT_TIMESTAMP');

      DB::table('UsuarioTyC')->insert($datatyc);
    }
    try {
      /*Envio de mail*/
      $datamail["email"] = $request->email;
      $datamail["title"] = "Alta Usuario";

      $files = [
        public_path('storage/uploads/pasos/PrimerInicio.pdf'),

      ];



      Mail::send('backend.mail.Test_mail', $datamail, function ($message) use ($datamail, $files) {
        $message->to($datamail["email"])
          ->subject($datamail["title"]);
        foreach ($files as $file) {
          $message->attach($file);
        }
      });
    } catch (\Throwable $t) {
      echo ($t->getMessage());
    }

    return redirect()->route('usuarios.index')
      ->with(['success', 'El usuario fue creado satisfactoriamente.']);
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
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'GrupoUsuario.descripcion as grupo'
      )->where('Usuario.id', '=', $id)->first();

    $user = Usuario::find($usuario->id);
    $roles = $user->getRoleNames();

    return view('backend.usuarios.show', ['usuario' => $usuario, 'roles' => $roles]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\HomeRedes  $HomeRedes
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'GrupoUsuario.descripcion as grupo',
        'Usuario.idGrupoUsuario as grupoId'
      )->where('Usuario.id', '=', $id)->first();
    //dd($usuario);

    $usuario = new Usuario();
    $usuario->id = $data->id;
    $usuario->nombre = $data->nombre;
    $usuario->apellido = $data->apellido;
    $usuario->CUIT = $data->CUIT;
    $usuario->email = $data->email;
    $usuario->emailSecundario = $data->emailSecundario;
    $usuario->fechaAlta = $data->fechaAlta;
    $usuario->fechaBaja = $data->fechaBaja;
    $usuario->grupo = $data->grupo;
    $usuario->grupoId = $data->grupoId;
    $roles = Role::all();

    //dd($grupos);
    return view('backend.usuarios.edit', [
      'usuario' => $usuario, 'roles' => $roles
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

    /*  dd($request);
     dd($id); */
    $grupoDelegado = DB::table('GrupoUsuario')->where('descripcion', 'Delegado')->first();
    $idGrupoDelegado = $grupoDelegado->id;
    $data['nombre'] = $request->nombre;
    $data['apellido'] = $request->apellido;
    $data['CUIT'] = $request->cuit;
    $data['email'] = $request->email;
    $data['emailSecundario'] = $request->email2;
    $data['idGrupoUsuario'] = $idGrupoDelegado;

    DB::table('Usuario')
      ->where('id', $id)
      ->update($data);
    //Log de edicion
    LogActivity::addToLog('Usuario Editado:' . $data["email"]);
    //obtengo el usuario agregado
    $user = Usuario::find($id);
    // Remueve todos los roles del usuario
    $user->syncRoles([]);
    // Obtener los roles seleccionados desde la solicitud
    $roles = $request->input('roles');

    // Asignar los roles al usuario
    $user->assignRole($roles);

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
    $data['email'] = '';

    DB::table('Usuario')->where('id', $id)->update($data);
    $element = DB::table('Usuario')->where('id', $id)->first();

    LogActivity::addToLog('Usuario - Dió de baja: ' . $element->nombre);

    return redirect()->route('usuarios.index')
      ->with('success', 'El usuario se ha borrado con éxito');
  }

  public function search($id)
  {
    dd($id);
  }

  public function habilitar($id)
  {
    $usuario = DB::table('Usuario')->where('id', $id)->first();
    $data['fechaBaja'] = NULL;

    DB::table('Usuario')
      ->where('id', $id)
      ->update($data);
    //Log de habilitacion
    LogActivity::addToLog('Usuario Habilitado:' . $usuario->nombre);
    $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Usuario Simulacion%')->first();
    $idGrupoSimulacion = $grupoSimulacion->id;

    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'GrupoUsuario.descripcion as grupo'
      )
      ->where('TipoPersona.id', '=', 1)
      ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
      ->get();

    foreach ($usuarios as $usuario) {
      $usuario->roles = DB::table('model_has_roles')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('model_has_roles.model_id', $usuario->id)
        ->pluck('roles.name')
        ->toArray();
    }


    return view('backend.usuarios.index', [
      'usuarios' => $usuarios
    ]);
  }
}
