<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\ArchivoNombreCargadoService;

class HomeEmpresasController extends Controller
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

    $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
    $idGrupoSimulacion = $grupoSimulacion->id;


    if ($estado == 1) {
      $usuarios = DB::table('Usuario')
        ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
        ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
        ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
        ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
        ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
        ->select(
          'Usuario.id as id',
          'CUIT',
          'razonSocial',
          'email',
          'emailSecundario',
          'nombreFantasia',
          'esPionera',
          'Usuario.fechaAlta as fechaAlta',
          'Usuario.fechaBaja as fechaBaja',
          'GrupoUsuario.descripcion as grupo',
          'CategoriaEntidad.descripcion as categoria',
          'Provincias.nombre as nombreProvincia'
        )
        ->where('TipoPersona.id', '=', 2)
        ->where('Usuario.fechaBaja', NULL)
        ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
        ->get();
    }

    if ($estado == 0) {
      $usuarios = DB::table('Usuario')
        ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
        ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
        ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
        ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
        ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
        ->select(
          'Usuario.id as id',
          'CUIT',
          'razonSocial',
          'email',
          'emailSecundario',
          'nombreFantasia',
          'esPionera',
          'Usuario.fechaAlta as fechaAlta',
          'Usuario.fechaBaja as fechaBaja',
          'GrupoUsuario.descripcion as grupo',
          'CategoriaEntidad.descripcion as categoria',
          'Provincias.nombre as nombreProvincia'
        )
        ->where('TipoPersona.id', '=', 2)
        ->where('Usuario.fechaBaja', '!=', NULL)
        ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
        ->get();
    }

    if ($estado == 9) {
      $usuarios = DB::table('Usuario')
        ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
        ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
        ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
        ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
        ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
        ->select(
          'Usuario.id as id',
          'CUIT',
          'razonSocial',
          'email',
          'emailSecundario',
          'nombreFantasia',
          'esPionera',
          'Usuario.fechaAlta as fechaAlta',
          'Usuario.fechaBaja as fechaBaja',
          'GrupoUsuario.descripcion as grupo',
          'CategoriaEntidad.descripcion as categoria',
          'Provincias.nombre as nombreProvincia'
        )
        ->where('TipoPersona.id', '=', 2)
        ->get();
    }



    return view('backend.empresas.index', [
      'usuarios' => $usuarios
    ]);
  }
  public function index()
  {

    $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
    $idGrupoSimulacion = $grupoSimulacion->id;

    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
      ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
      ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
      ->select(
        'Usuario.id as id',
        'CUIT',
        'razonSocial',
        'email',
        'emailSecundario',
        'nombreFantasia',
        'esPionera',
        'Usuario.fechaAlta as fechaAlta',
        'Usuario.fechaBaja as fechaBaja',
        'GrupoUsuario.descripcion as grupo',
        'CategoriaEntidad.descripcion as categoria',
        'Provincias.nombre as nombreProvincia'
      )
      ->where('TipoPersona.id', '=', 2)
      ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
      ->get();



    return view('backend.empresas.index', [
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
    $provincias = DB::table('Provincias')->get();

    return view('backend.empresas.create', ['grupos' => $grupos, 'provincias' => $provincias]);
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, ArchivoNombreCargadoService $serviceNombre)
  {
    if (!empty($request->file('logo'))) {
      $data['logo'] = $serviceNombre->GenerarNombreYMiniaturaDeImagen($request->file('logo'), 'Usuario', 'Usuario', 'logo');
    }

    $data['razonSocial'] = $request->razonSocial;
    $data['CUIT'] = $request->cuit;
    $data['idGrupoUsuario'] = $request->grupo;
    $data['idTipoPersona'] = 2;
    $data['email'] = $request->email;
    $data['emailSecundario'] = $request->email2;
    $data['idProvincia'] = $request->provincia;
    $data['nombreFantasia'] = $request->fantasia;
    $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

    if ($request->esPionera == 'on') {
      $data['esPionera'] = 1;
    } else {
      $data['esPionera'] = 0;
    }

    DB::table('Usuario')->insert($data);
    //Log de creacion
    LogActivity::addToLog('Entidad Creada:' . $data['email']);
    return redirect()->route('empresas.index')
      ->with('success', 'La empresa fue creada satisfactoriamente.');
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
      ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
      ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
      ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
      ->select(
        'Usuario.id as id',
        'CUIT',
        'razonSocial',
        'email',
        'emailSecundario',
        'nombreFantasia',
        'esPionera',
        'Usuario.fechaAlta as fechaAlta',
        'Usuario.fechaBaja as fechaBaja',
        'GrupoUsuario.descripcion as grupo',
        'CategoriaEntidad.descripcion as categoria',
        'Usuario.logo as logo',
        'Provincias.nombre as nombreProvincia'
      )
      ->where('Usuario.id', '=', $id)->first();

    return view('backend.empresas.show', ['usuario' => $usuario]);
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
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
      ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
      ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
      ->select(
        'Usuario.id as id',
        'CUIT',
        'razonSocial',
        'email',
        'emailSecundario',
        'nombreFantasia',
        'esPionera',
        'Usuario.fechaAlta as fechaAlta',
        'Usuario.fechaBaja as fechaBaja',
        'GrupoUsuario.descripcion as grupo',
        'CategoriaEntidad.descripcion as categoria',
        'Usuario.idGrupoUsuario as grupoId',
        'Usuario.logo as logo',
        'Provincias.nombre as nombreProvincia',
        'Usuario.idProvincia as idProvincia'
      )
      ->where('Usuario.id', '=', $id)->first();

    $grupos = DB::table('GrupoUsuario')->get();
    $provincias = DB::table('Provincias')->get();


    return view('backend.empresas.edit', [
      'usuario' => $usuario, 'grupos' => $grupos,
      'provincias' => $provincias
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\HomeRedes  $HomeRedes
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
  {


    $data['razonSocial'] = $request->razonSocial;
    $data['CUIT'] = $request->cuit;
    $data['idGrupoUsuario'] = $request->grupo;
    $data['email'] = $request->email;
    $data['emailSecundario'] = $request->email2;
    $data['idProvincia'] = $request->provincia;
    $data['nombreFantasia'] = $request->fantasia;
    if ($request->esPionera == 'on') {
      $data['esPionera'] = 1;
    } else {
      $data['esPionera'] = 0;
    }

    if (!empty($request->file('logo'))) $data['logo'] = $serviceNombre->GenerarNombreYMiniaturaDeImagen($request->file('logo'), 'Usuario', 'Usuario', 'logo', $id);

    DB::table('Usuario')
      ->where('id', $id)
      ->update($data);

    //Log de edicion
    LogActivity::addToLog('Entidad Editada:' . $data['email']);
    return redirect()->route('empresas.index')
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

    LogActivity::addToLog('Usuario - Dió de baja: ' . $element->razonSocial);

    return redirect()->route('empresas.index')
      ->with('success', 'La empresa se ha borrado con éxito');
  }

  public function habilitar($id)
  {

    $usuario = DB::table('Usuario')->where('id', $id)->first();
    $data['fechaBaja'] = NULL;

    DB::table('Usuario')
      ->where('id', $id)
      ->update($data);
    //Log de habilitacion
    LogActivity::addToLog('Entidad Habilitada:' . $usuario->razonSocial);
    $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
    $idGrupoSimulacion = $grupoSimulacion->id;

    $usuarios = DB::table('Usuario')
      ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
      ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
      ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
      ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
      ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
      ->select(
        'Usuario.id as id',
        'CUIT',
        'razonSocial',
        'email',
        'emailSecundario',
        'nombreFantasia',
        'esPionera',
        'Usuario.fechaAlta as fechaAlta',
        'Usuario.fechaBaja as fechaBaja',
        'GrupoUsuario.descripcion as grupo',
        'CategoriaEntidad.descripcion as categoria',
        'Provincias.nombre as nombreProvincia'
      )
      ->where('TipoPersona.id', '=', 2)
      ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
      ->get();



    return view('backend.empresas.index', [
      'usuarios' => $usuarios
    ]);
  }
}
