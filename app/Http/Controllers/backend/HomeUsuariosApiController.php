<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use App\Helpers\LogActivity;

class HomeUsuariosApiController extends Controller
{
  public function index()
  {
    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->join('oauth_clients', 'oauth_clients.user_id', 'Usuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'API_Activo',
        'GrupoUsuario.descripcion as grupo',
        'oauth_clients.id as client_id',
        'oauth_clients.secret as client_secret',
        'oauth_clients.revoked as activo'
      )
      ->where('TipoPersona.id', '=', 1)
      ->where('oauth_clients.name', 'Access Grant')
      ->get();

    return view('backend.usuarios_api.index', ['usuarios' => $usuarios]);
  }

  public function create()
  {
    return view('backend.usuarios_api.create');
  }

  public function store(Request $request)
  {
    $cuit = $request->cuit;
    $email = $request->email;

    $userCUIT = DB::table('Usuario')->where('CUIT', $cuit)->first();

    $userEmail = DB::table('Usuario')->where('email', $email)->first();

    if ($userCUIT) {
      return redirect()->back()->with('error', 'Ya existe un usuario con ese CUIT')->withInput();
    }
    if ($userEmail) {
      return redirect()->back()->with('error', 'Ya existe usuario con ese email')->withInput();
    }

    $usuarioAPI = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%API%')->first();

    $data['CUIT'] = $cuit;
    $data['email'] = $email;
    $data['idTipoPersona'] = 1;
    $data['nombre'] = $request->nombre;
    $data['apellido'] = $request->apellido;
    $data['idGrupoUsuario'] = $usuarioAPI->id;
    $data['password'] = Hash::make($request->password);
    $data['API_Activo'] = 1;
    $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

    $userId = DB::table('Usuario')->insertGetId($data);

    // Create Passport client for the user
    $client = new Client();
    $client->user_id = $userId;
    $client->name = 'Access Grant'; // Set a name for your client
    $client->secret = Hash::make('your-secret'); // You can generate a secure secret here
    $client->redirect = '';
    $client->personal_access_client = 0;
    $client->password_client = 1;
    $client->revoked = 0;
    $client->save();


    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->join('oauth_clients', 'oauth_clients.user_id', 'Usuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'API_Activo',
        'GrupoUsuario.descripcion as grupo',
        'oauth_clients.id as client_id',
        'oauth_clients.secret as client_secret',
        'oauth_clients.revoked as activo'
      )
      ->where('TipoPersona.id', '=', 1)
      ->where('oauth_clients.name', 'Access Grant')
      ->get();

    LogActivity::addToLog('Creación nuevo usuario API: ' . $email);
    return view('backend.usuarios_api.index', ['usuarios' => $usuarios]);
  }

  public function show($id)
  {
    // Implementation of the show method, if needed
  }


  public function giveAccess()
  {
    $grupoUsuarioPrueba = DB::table('GrupoUsuario')
      ->where('descripcion', 'LIKE', '%Prueba%')
      ->first();
    $grupoUsuarioSimulacion = DB::table('GrupoUsuario')
      ->where('descripcion', 'LIKE', '%Simulacion%')
      ->first();
    $usuarios = DB::table('Usuario')
      ->where('idTipoPersona', 1)
      ->where('idGrupoUsuario', '!=', $grupoUsuarioPrueba->id)
      ->where('idGrupoUsuario', '!=', $grupoUsuarioSimulacion->id)
      ->where('fechaBaja', NULL)
      ->where('API_Activo',0)
      ->get();


    return view('backend.usuarios_api.darAcceso', ['usuarios' => $usuarios]);
  }

  public function saveAccess(Request $request)
  {
    $idUsuario = $request->usuario_api;

    $existe = DB::table('oauth_clients')->where('user_id', $idUsuario)->first();
    if ($existe) {
      return redirect()->back()->with('error', 'Ese usuario ya tiene acceso a la API');
    } else {
      // Create Passport client for the user
      $client = new Client();
      $client->user_id = $idUsuario;
      $client->name = 'Access Grant'; // Set a name for your client
      $client->secret = Hash::make('your-secret'); // You can generate a secure secret here
      $client->redirect = '';
      $client->personal_access_client = 0;
      $client->password_client = 1;
      $client->revoked = 0;
      $client->save();
    }

    DB::table('Usuario')->where('id',$idUsuario)->update(['API_Activo' => 1]);
    $usuarioAltaAPI =  DB::table('Usuario')->where('id',$idUsuario)->first();

    LogActivity::addToLog('Dar acceso usuario existente API: ' . $usuarioAltaAPI->email);

    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->join('oauth_clients', 'oauth_clients.user_id', 'Usuario.id')
      ->select(
        'Usuario.id as id',
        'nombre',
        'apellido',
        'CUIT',
        'email',
        'emailSecundario',
        'fechaAlta',
        'fechaBaja',
        'API_Activo',
        'GrupoUsuario.descripcion as grupo',
        'oauth_clients.id as client_id',
        'oauth_clients.secret as client_secret',
        'oauth_clients.revoked as activo'
      )
      ->where('TipoPersona.id', '=', 1)
      ->where('oauth_clients.name', 'Access Grant')
      ->get();

      return redirect()->route('usuarios_api.index',['usuarios'=> $usuarios])->with('success', 'Acceso agregado correctamente');
  }

  public function revokeAccess($id)
  {
    // Update the 'revoked' field in the oauth_clients table for the given user
    DB::table('Usuario')->where('id', $id)->update(['API_Activo' => 0]);

    $revokeUsuarioAccessAPI =  DB::table('Usuario')->where('id',$id)->first();
    LogActivity::addToLog('Revocar acceso usuario API: ' . $revokeUsuarioAccessAPI->email);
    // Redirect back or perform any other necessary actions
    return redirect()->back()->with('success', 'Se revoco el acceso correctamente');
  }

  public function activateAccess($id)
  {
    // Update the 'revoked' field in the oauth_clients table for the given user
    DB::table('Usuario')->where('id', $id)->update(['API_Activo' => 1]);
    $giveUsuarioAccessAPI =  DB::table('Usuario')->where('id',$id)->first();
    LogActivity::addToLog('Habilitar acceso usuario API: ' . $giveUsuarioAccessAPI->email);
    // Redirect back or perform any other necessary actions
    return redirect()->back()->with('success', 'Se activo el acceso correctamente');
  }
}
