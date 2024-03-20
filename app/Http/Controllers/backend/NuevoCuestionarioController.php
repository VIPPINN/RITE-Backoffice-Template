<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;
use Illuminate\Support\Facades\Log;


class NuevoCuestionarioController extends Controller
{

  public function index()
  {
    $cuestionarios = DB::table('Cuestionario')
      ->where('fechaBaja', null)
      ->get();

    return view('backend.nuevoCuestionario.index', [
      'cuestionarios' => $cuestionarios
    ]);
  }


  public function versiones($id)
  {

    $versiones = DB::table('CuestionarioVersion')->where('idCuestionario', $id)
      ->where('fechaBaja', null)
      ->get();
    $versionescount = DB::table('CuestionarioVersion')->where('idCuestionario', $id)
      ->where('fechaBaja', null)->count();

    if ($versionescount == 0) {
      $primeraversioncuestionario = 1;
      $cuestionarioVersionEstado = 0;
    } else {
      $primeraversioncuestionario = 0;
      $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
        ->select('estadoAoI')
        ->where('id', $id)
        ->where('fechaBaja', null)
        ->first();
      if ($cuestionarioVersionEstado) {
        $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;
      } else {
        $cuestionarioVersionEstado = 0;
      }
    }

    return view('backend.nuevoCuestionario.indexVersiones', [
      'cuestionariosVersion' => $versiones, 'idCuestionario' => $id,
      'primeraversioncuestionario' => $primeraversioncuestionario,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function temas($id)
  {
    $temas = DB::table('Tema')->where('idCuestionarioVersion', $id)
      ->where('fechaBaja', null)
      ->get();

    $idCuestionarioVolver = DB::table('CuestionarioVersion')
      ->where('fechaBaja', null)->where('id', $id)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $idCuestionarioVolver->id)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemas', [
      'temas' => $temas, 'idCuestionarioVolver' => $idCuestionarioVolver,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function preguntas(Request $request, $id)
  {
    if (!empty($request->buscarPregunta)) {
      $descripcion = $request->buscarPregunta;
      $preguntas = DB::table('Pregunta')->where('idTema', $id)->where('pregunta', 'LIKE', "%$descripcion%")->where('fechaBaja', null)->get();
    } else {
      $preguntas = DB::table('Pregunta')->where('idTema', $id)->where('fechaBaja', null)->get();
    }


    $tema = DB::table('Tema')->where('id', $id)->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntas', [
      'preguntas' => $preguntas, 'idTema' => $tema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function opciones($id)
  {

    $opciones = DB::table('PreguntaOpcion')->where('idPregunta', $id)
      ->where('fechaBaja', null)->get();

    $pregunta = DB::table("Pregunta")->where('id', $id)
      ->where('fechaBaja', null)->first();

    $tema = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpciones', [
      'opciones' => $opciones, 'idPregunta' => $id, 'idTema' => $pregunta->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function opcionesImpactan($id)
  {
    $opcionesImpactan = DB::table('OpcionPreguntaImpacta')
      ->where('idPregunta', $id)
      ->where('fechaBaja', null)
      ->get();

    $pregunta = DB::table("Pregunta")->where('id', $id)
      ->where('fechaBaja', null)
      ->first();

    $tema = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;
    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpcionesImpactan', [
      'opciones' => $opcionesImpactan, 'idPregunta' => $id, 'idTema' => $pregunta->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }


  public function crearCuestionario()
  {
    return view('backend.nuevoCuestionario.crearCuestionario');
  }

  public function guardarCuestionario(Request $request)
  {

    $request->validate(
      [
        'descripcion' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
      ]
    );


    $data = array();
    $data['descripcion']        = $request->descripcion;
    if ($request->estadoTyC == null) {
      $data['estadoTyC']            = false;
    } else {
      $data['estadoTyC']            = true;
    }
    if ($request->estadoAoI == null) {
      $data['estadoAoI']            = false;
    } else {
      $data['estadoAoI']            = true;
    }
    $data['activoSimulacion'] = true;

    DB::table('Cuestionario')->insert($data);


    $usuarios = DB::table('Usuario')->where('idTipoPersona', 1)->get();
    $cuestionariomaxid = DB::table('Cuestionario')->where('fechaBaja', null)->max('id');

    foreach ($usuarios as $index => $usuario) {
      $datatyc['idUsuario']        = $usuario->id;
      $datatyc['idCuestionario']   = $cuestionariomaxid;
      $datatyc['estadoTyC']        = 0;
      $datatyc['fechaAlta']        = DB::raw('CURRENT_TIMESTAMP');

      DB::table('UsuarioTyC')->insert($datatyc);
    }

    $cuestionarios = DB::table('Cuestionario')
      ->where('fechaBaja', null)
      ->get();
    foreach ($cuestionarios as $index => $cuestionario) {

      $cuestionaresanteriores = DB::table('UsuarioTyC')
        ->where('idCuestionario', $cuestionario->id)->count();
      if ($cuestionaresanteriores == 0) {
        foreach ($usuarios as $index => $usuario) {
          $datatyc['idUsuario']        = $usuario->id;
          $datatyc['idCuestionario']   = $cuestionario->id;
          $datatyc['estadoTyC']        = 0;
          $datatyc['fechaAlta']        = DB::raw('CURRENT_TIMESTAMP');

          DB::table('UsuarioTyC')->insert($datatyc);
        }
      }
    }

    return view('backend.nuevoCuestionario.index', [
      'cuestionarios' => $cuestionarios
    ]);
  }
  public function edit($id)
  {

    $cuestionario = DB::table('Cuestionario')->where('id', $id)
      ->where('fechaBaja', null)->first();

    return view('backend.nuevoCuestionario.edit')
      ->with([
        'cuestionario' => $cuestionario,
      ]);
  }

  public function update(Request $request, $id)
  {

    $request->validate(
      [
        'descripcion' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla. ',
      ]
    );

    $data = array();
    $data['descripcion']       = $request->descripcion;
    if ($request->estadoAoI == null) {
      $data['estadoAoI']            = 0;
    }
    if ($request->estadoAoI == "on") {
      $data['estadoAoI']            = 1;
    }
    if ($request->estadoTyC == null) {
      $data['estadoTyC']            = false;
    } else {
      $data['estadoTyC']            = true;
    }
    if ($request->estadoSimulacion == "on") {
      $data['activoSimulacion'] = true;
    } else {
      $data['activoSimulacion'] = false;
    }

    DB::table('Cuestionario')
      ->where('id', $id)
      ->update($data);

    return redirect()->route('nuevoCuestionario.index')
      ->with('success', 'El registro se ha actualizado con éxito');
  }
  public function crearVersion($id)
  {

    return view('backend.nuevoCuestionario.crearVersion', ['idCuestionario' => $id]);
  }

  public function guardarVersion(Request $request)
  {
    $request->validate(
      [
        'descripcion' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
      ]
    );

    //ACA SE TIENE QUE GENERAR TODO EL CUESTIONARIO-> CON LA NUEVA VERSION->CON LOS TEMAS DEL CUESTIONARIO ANTERIOR->CON LAS PREGUNTAS DEL CUESTIOANRIO ANTERIOR->CON LAS OPCIONES DEL CUESTIOANRIO ANTERIOR->CON LAS OPCIOENS QUE IMAPCTAN DEL CUESTIOANRIO ANTERIOR



    $versiones = DB::table('CuestionarioVersion')
      ->where('idCuestionario', $request->idCuestionario)
      ->where('fechaBaja', null)->get();
    $versionescount = DB::table('CuestionarioVersion')
      ->where('idCuestionario', $request->idCuestionario)
      ->where('fechaBaja', null)->count();

    if ($versionescount == 0) {
      $data = array();
      $data['descripcion']        = $request->descripcion;
      $data['idCuestionario']     = $request->idCuestionario;
      $data['fechaAlta']          = DB::raw('CURRENT_TIMESTAMP');
      $data['estadoAoI']          = false;
      $data['activoSimulacion']   = true;


      DB::table('CuestionarioVersion')->insert($data);

      $primeraversioncuestionario = 0;
      $versiones = DB::table('CuestionarioVersion')
        ->where('idCuestionario', $request->idCuestionario)
        ->where('fechaBaja', null)->get();
    } else {
      $primeraversioncuestionario = 0;
      $maxversionvieja = DB::table('CuestionarioVersion')
        ->where('idCuestionario', $request->idCuestionario)
        ->where('fechaBaja', null)->max('id');

      $data['descripcion']        = $request->descripcion;
      $data['idCuestionario']     = $request->idCuestionario;
      $data['fechaAlta']          = DB::raw('CURRENT_TIMESTAMP');
      if ($request->estado == null) {
        $data['estadoAoI']            = false;
      } else {
        $data['estadoAoI']            = true;
      }

      /* //si ya hay version tengo que poner el anterior activoSimulacion en false y este en true
      $versionAnteriorEnSimulacion = DB::table('CuestionarioVersion')
      ->where('idCuestionario', $request->idCuestionario)
      ->where('fechaBaja', null)->where('activoSimulacion',1)->first();

      if(!empty($versionAnteriorEnSimulacion)){
        $actualizarEstadoSimulacion['activoSimulacion'] = false;

        DB::table('CuestionarioVersion')->where('id',$versionAnteriorEnSimulacion->id)->update($actualizarEstadoSimulacion);
      }
     


      //activo en simulacion el que estoy creando
      $data['activoSimulacion'] = true;  */
      DB::table('CuestionarioVersion')->insert($data);
      $maxversionnueva = DB::table('CuestionarioVersion')
        ->where('fechaBaja', null)->max('id');


      $temasversion = DB::table('Tema')
        ->where('idCuestionarioVersion', $maxversionvieja)
        ->where('fechaBaja', null)->get();
      $temaviejo = DB::table('Tema')
        ->where('idCuestionarioVersion', $maxversionvieja)
        ->where('fechaBaja', null)->max('id');

      foreach ($temasversion as $index => $temaversion) {
        $data1['idCuestionarioVersion']  = $maxversionnueva;
        $data1['orden']                  = $temaversion->orden;
        $data1['descripcion']            = $temaversion->descripcion;
        $data1['idTemaViejo']            = $temaversion->id;

        DB::table('Tema')->insert($data1);

        $temanuevo = DB::table('Tema')
          ->where('fechaBaja', null)->max('id');

        $preguntasversion = DB::table('Pregunta')
          ->where('fechaBaja', null)
          ->where('idTema', $temaversion->id)
          ->get();


        foreach ($preguntasversion as $index => $preguntaversion) {
          $dataPregunta['pdf'] = $preguntaversion->pdf;
          $dataPregunta['idCuestionarioVersion'] = $maxversionnueva;
          $dataPregunta['idViejo'] = $preguntaversion->id;

          $ultimoNumero = DB::table('Pregunta')->select('numero')->orderby('numero', 'desc')->first();
          $ultimoNumero = (int)$ultimoNumero->numero;
          $dataPregunta['numero'] = ($ultimoNumero + 1);

          //busco la pregunta que en idViejo tiene idPreguntaPadre 
          if ($preguntaversion->idPreguntaPadre != NULL) {
            $idPreguntaPadreActualizado = DB::table('Pregunta')->where('idViejo', $preguntaversion->idPreguntaPadre)->orderBy('id', 'desc')->first();
            //lo guardo en el nuevo idPreguntaPadre
            if (!empty($idPreguntaPadreActualizado)) {
              $dataPregunta['idPreguntaPadre'] = $idPreguntaPadreActualizado->id;
            }
          } else {
            $dataPregunta['idPreguntaPadre'] = $preguntaversion->idPreguntaPadre;
          }


          $dataPregunta['idTema'] = $temanuevo;
          $dataPregunta['pregunta'] = $preguntaversion->pregunta;
          $dataPregunta['idTipoPregunta'] = $preguntaversion->idTipoPregunta;
          $dataPregunta['respuestaDisparadorSubpregunta'] = $preguntaversion->respuestaDisparadorSubpregunta;
          $dataPregunta['impactoNivelAvance'] = $preguntaversion->impactoNivelAvance;
          $dataPregunta['requiereEvidencia'] = $preguntaversion->requiereEvidencia;
          $dataPregunta['opcionesSugeridas'] = $preguntaversion->opcionesSugeridas;
          $dataPregunta['cantidadMesesVencimiento'] = $preguntaversion->cantidadMesesVencimiento;
          $dataPregunta['fechaAlta'] =  date("Y-m-d");

          DB::table('Pregunta')->insert($dataPregunta);

          $preguntanueva = DB::table('Pregunta')->where('fechaBaja', null)->max('id');

          $opcionimpactaversiones = DB::table('OpcionPreguntaImpacta')
            ->where('idPregunta', $preguntaversion->id)
            ->where('fechaBaja', null)
            ->get();

          foreach ($opcionimpactaversiones as $index => $opcionimpactaversion) {
            $dataop['opcion'] = $opcionimpactaversion->opcion;
            $dataop['idPregunta'] =  $preguntanueva;

            DB::table('OpcionPreguntaImpacta')->insert($dataop);
          }
          $preguntaNivel = DB::table('PreguntaNivel')
            ->where('idPregunta', $preguntaversion->id)
            ->get();
          foreach ($preguntaNivel as $index => $preguntanivelitem) {
            $datapn['idPregunta'] =  $preguntanueva;
            $datapn['idGrupoEntidad'] =  $preguntanivelitem->idGrupoEntidad;
            $datapn['idCategoriaEntidad'] =  $preguntanivelitem->idCategoriaEntidad;
            $datapn['idNivel'] =  $preguntanivelitem->idNivel;

            DB::table('PreguntaNivel')->insert($datapn);
          }

          $preguntaOpcion = DB::table('PreguntaOpcion')
            ->where('idPregunta', $preguntaversion->id)
            ->where('fechaBaja', null)
            ->get();
          foreach ($preguntaOpcion as $index => $preguntaopcionitem) {
            $datapo['idPregunta'] =  $preguntanueva;
            $datapo['orden'] =  $preguntaopcionitem->orden;
            $datapo['descripcion'] =  $preguntaopcionitem->descripcion;


            DB::table('PreguntaOpcion')->insert($datapo);
          }
        }
      }
      $versiones = DB::table('CuestionarioVersion')
        ->where('idCuestionario', $request->idCuestionario)
        ->where('fechaBaja', null)->get();
    }

    return view('backend.nuevoCuestionario.indexVersiones', [
      'cuestionariosVersion' => $versiones, 'idCuestionario' => $request->idCuestionario,
      'primeraversioncuestionario' => $primeraversioncuestionario,
    ]);
  }

  function crearTema($id)
  {

    return view('backend.nuevoCuestionario.crearTema', ['idCuestionarioVersion' => $id]);
  }

  function guardarTema(Request $request)
  {

    $existe = DB::table('Tema')
      ->where('idCuestionarioVersion', $request->idCuestionarioVersion)
      ->where('descripcion', $request->descripcion)
      ->where('fechaBaja', null)->first();

    if (empty($existe)) {
      $data['idCuestionarioVersion'] = $request->idCuestionarioVersion;
      $data['orden']                 = $request->orden;
      $data['descripcion']           = $request->descripcion;

      DB::table('Tema')->insert($data);
    }

    $temas = DB::table('Tema')->where('idCuestionarioVersion', $request->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->get();

    $idCuestionarioVolver = DB::table('CuestionarioVersion')
      ->where('id', $request->idCuestionarioVersion)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->where('id', $idCuestionarioVolver->id)
      ->where('fechaBaja', null)
      ->first();

    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;


    return view('backend.nuevoCuestionario.indexVersionesTemas', [
      'temas' => $temas, 'idCuestionarioVolver' => $idCuestionarioVolver,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function crearPregunta($id)
  {
    $temas = DB::table('Tema')->where('idCuestionarioVersion', $id)
      ->where('fechaBaja', null)
      ->get();

    $tema = DB::table('Tema')->where('id', $id)
      ->where('fechaBaja', null)->first();

    $tiposPregunta = DB::table('TipoPregunta')->get();

    $gruposEntidad = DB::table('GrupoEntidad')->get();

    $categoriasEntidad = DB::table('CategoriaEntidad')->get();

    $preguntas = DB::table('Pregunta')
      ->select(
        'Pregunta.id AS id',
        'Pregunta.pregunta AS pregunta',
        'Pregunta.numero AS numero'
      )->where('idTema', $tema->id)
      ->where('fechaBaja', null)
      ->get();

    $numeromaximo = DB::table('Pregunta')
      ->where('fechaBaja', null)
      ->max('numero');

    $numeromaximo = $numeromaximo + 1;

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();

    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;


    return view('backend.nuevoCuestionario.crearPregunta', [
      'idTema' => $id,
      'tema' => $tema,
      'tiposPregunta' => $tiposPregunta,
      'preguntas' => $preguntas,
      'gruposEntidad' => $gruposEntidad,
      'categoriasEntidad' => $categoriasEntidad,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado,
      'numeromaximo' => $numeromaximo
    ]);
  }

  function guardarPregunta(Request $request, ArchivoNombreCargadoService $serviceNombre)
  {
    $request->validate(
      [
        'pregunta' => 'required',
        'idTema' => 'required',
        'idTipoPregunta' => 'required',
        'numero' => 'required',
        'cantidadMesesVencimiento' => 'required',
      ],
      [
        'pregunta.required' => '(*) La pregunta es requerida. Debe ingresarlo. ',
        'idTema.required'  => '(*) El tema es requerido. Debe seleccionar una opciòn. ',
        'idTipoPregunta.required' => '(*) El tipo de pregunta es requerido. Debe seleccionar una opciòn. ',
        'numero.required' => '(*) El Nº de pregunta es requerido. Debe ingresarlo. ',
        'cantidadMesesVencimiento.required' => '(*) La cantidad de meses para el vencimiento es requerido. Debe ingresarlo. ',
      ]
    );


    $idCuestionarioVersion = DB::table('Tema')
      ->where('id', $request->idTema)
      ->where('fechaBaja', null)
      ->first();

    if ($request->pdf) {
      $dataPregunta['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Pregunta', 'Pregunta', 'pdf');
    }


    $dataPregunta['idCuestionarioVersion'] = $idCuestionarioVersion->idCuestionarioVersion;
    $dataPregunta['numero'] = $request->numero;
    $dataPregunta['idPreguntaPadre'] = $request->idPreguntaPadre;
    $dataPregunta['idTema'] = $request->idTema;
    $dataPregunta['pregunta'] = $request->pregunta;
    $dataPregunta['idTipoPregunta'] = $request->idTipoPregunta;
    $dataPregunta['respuestaDisparadorSubpregunta'] = $request->respuestaDisparadorSubpregunta;
    $dataPregunta['impactoNivelAvance'] = $request->impactoNivelAvance;
    $dataPregunta['requiereEvidencia'] = $request->requiereEvidencia;
    $dataPregunta['opcionesSugeridas'] = $request->opcionesSugeridas;
    $dataPregunta['cantidadMesesVencimiento'] = $request->cantidadMesesVencimiento;
    $dataPregunta['fechaAlta'] =  date("Y-m-d");
    $dataPregunta['nombrePDF'] = $request->nombrePdf;
    try {
      DB::table('Pregunta')->insert($dataPregunta);
    } catch (\Throwable $t) {
      echo ($t);
    }
    /*  $getIdPregunta =DB::table('Pregunta')->where('pregunta',$request->pregunta)
   ->where('fechaBaja',null)->first();
 */

    $getIdPregunta = DB::table('Pregunta')->where('pregunta', $request->pregunta)
      ->where('fechaBaja', null)->first();

    if ($request->idTipoPregunta == 1 || $request->idTipoPregunta == 2) {
      $dataPreguntaOpcionImpacta['idPregunta'] = $getIdPregunta->id;
      $dataPreguntaOpcionImpacta['opcion'] = "SI";
      try {
        DB::table('OpcionPreguntaImpacta')->insert($dataPreguntaOpcionImpacta);
      } catch (\Throwable $t) {
        echo ($t);
      }
    }


    $cantidad_GrupoEntidad = DB::table('GrupoEntidad')->count('id');


    $cantidad_CategoriaEntidad = DB::table('CategoriaEntidad')->count('id');

    $idPregunta = DB::table('Pregunta')->where('numero', $request->numero)
      ->where('fechaBaja', null)
      ->first();

    for ($i = 1; $i <= $cantidad_GrupoEntidad; $i++) {
      for ($j = 1; $j <= $cantidad_CategoriaEntidad; $j++) {
        $imprimir = "opcionImpacta_" . $i . "_" . $j;
        $dataOpcionImpacta['idPregunta'] = $idPregunta->id;
        $dataOpcionImpacta['idGrupoEntidad'] = $i;
        $dataOpcionImpacta['idCategoriaEntidad'] = $j;
        $dataOpcionImpacta['idNivel'] = $request->$imprimir;
        if ($request->$imprimir != 0) {
          try {
            DB::table('PreguntaNivel')->insert($dataOpcionImpacta);
          } catch (\Throwable $t) {
            dd($t);
            echo $t;
          }
        }
      }
    }


    $preguntas = DB::table('Pregunta')
      ->where('idTema', $request->idTema)
      ->where('fechaBaja', null)->get();

    $tema = DB::table('Tema')->where('id', $request->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();

    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;


    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntas', [
      'preguntas' => $preguntas, 'idTema' => $tema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function crearOpcion($id)
  {
    $pregunta = DB::table('Pregunta')
      ->where('id', $id)
      ->where('fechaBaja', null)->first();

    return view('backend.nuevoCuestionario.crearOpcion', ['idPregunta' => $id, 'Pregunta' => $pregunta]);
  }

  public function guardarOpcion(Request $request)
  {
    $data['idPregunta'] = $request->idPregunta;
    $data['descripcion'] = $request->descripcion;
    $data['orden'] = 1;

    DB::table('PreguntaOpcion')->insert($data);

    $opciones = DB::table('PreguntaOpcion')->where('idPregunta', $request->idPregunta)
      ->where('fechaBaja', null)->get();
    $pregunta = DB::table('Pregunta')->where('id', $request->idPregunta)
      ->where('fechaBaja', null)->first();

    $tema = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpciones', [
      'opciones' => $opciones, 'idPregunta' => $request->idPregunta, 'idTema' => $pregunta->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function crearOpcionImpacta($id)
  {
    $pregunta = DB::table('Pregunta')->where('id', $id)
      ->where('fechaBaja', null)->first();

    return view(
      'backend.nuevoCuestionario.crearOpcionImpacta',
      ['idPregunta' => $id, 'Pregunta' => $pregunta]
    );
  }

  public function guardarOpcionImpacta(Request $request)
  {
    $pregunta = DB::table("Pregunta")->where('id', $request->idPregunta)
      ->where('fechaBaja', null)->first();

    //Busca las opciones ya cargadas para esta pregunta
    $opcionesCargadas = DB::table('OpcionPreguntaImpacta')
      ->where('idPregunta', $request->idPregunta)
      ->where('fechaBaja', null)->get();
    $cargado = 0;
    if (!$opcionesCargadas->isEmpty()) {

      foreach ($opcionesCargadas as $key => $opcion) {

        //compara la opcion que quiero agregar con cada opcion cargada
        if ($opcion->opcion == $request->respuestaImpacta) {
          //Si ya existe, devuelvo la lista sin guardar nada
          $opcionesImpactan = DB::table('OpcionPreguntaImpacta')
            ->where('idPregunta', $request->idPregunta)
            ->where('fechaBaja', null)->get();

          $pregunta = DB::table("Pregunta")
            ->where('id', $request->idPregunta)
            ->where('fechaBaja', null)
            ->first();
          $tema = DB::table('Tema')->where('id', $pregunta->idTema)
            ->where('fechaBaja', null)->first();

          $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
            ->select('estadoAoI')
            ->where('id', $tema->idCuestionarioVersion)
            ->where('fechaBaja', null)
            ->first();
          $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;
          return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpcionesImpactan', [
            'opciones' => $opcionesImpactan, 'idPregunta' => $request->idPregunta,
            'idTema' => $pregunta->idTema, 'cuestionarioVersionEstado' => $cuestionarioVersionEstado
          ]);
        } else {
          if ($cargado == 0) {
            //Si no existe, la guardo y devualevo la lista
            $data['opcion'] = $request->respuestaImpacta;
            $data['idPregunta'] = $request->idPregunta;

            DB::table('OpcionPreguntaImpacta')->insert($data);
            $cargado = 1;
          }
        }
      }
    } else {

      //Si no hay ninguna opcion cargada, la guardo
      $data['opcion'] = $request->respuestaImpacta;
      $data['idPregunta'] = $request->idPregunta;

      DB::table('OpcionPreguntaImpacta')->insert($data);
    }

    $opcionesImpactan = DB::table('OpcionPreguntaImpacta')
      ->where('idPregunta', $request->idPregunta)
      ->where('fechaBaja', null)->get();

    $pregunta = DB::table("Pregunta")
      ->where('id', $request->idPregunta)
      ->where('fechaBaja', null)
      ->first();
    $tema = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpcionesImpactan', [
      'opciones' => $opcionesImpactan, 'idPregunta' => $request->idPregunta, 'idTema' => $pregunta->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  /***********Ediciones***********/
  public function editarVersion($id)
  {
    $cuestionarioVersion = DB::table('CuestionarioVersion')
      ->where('id', $id)
      ->first();

    $Cuestionarios = DB::table('Cuestionario')->get();

    return view('backend.nuevoCuestionario.editarVersion', [
      'idCuestionario' => $id, 'cuestionarioVersion' => $cuestionarioVersion,
      'Cuestionarios' => $Cuestionarios
    ]);
  }


  public function editarVersionSave(Request $request)
  {
    $request->validate(
      [
        'descripcion' => 'required',
        'idCuestionario' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
        'idCuestionario.required' => '(*) El cuestionario es requerido. Debe seleccionarlo.',
      ]
    );


    $cuestionarioVersion = DB::table('CuestionarioVersion')
      ->where('idCuestionario', $request->idCuestionario)
      ->where('fechaBaja', null)
      ->first();


    $data = array();
    $data['descripcion']         = $request->descripcion;
    $data['idCuestionario']      = $request->idCuestionario;
    if ($request->estado == null) {
      $data['estadoAoI']            = false;
    } else {
      $data['estadoAoI']            = true;


      if ($request->estado == "on") {
        $data['estadoAoI']            = true;
      } else {
        $data['estadoAoI']            = false;
      }
    }
    if ($data['estadoAoI']  == true) {

      $cambiarestado = DB::table('CuestionarioVersion')
        ->where('estadoAoI', 1)
        ->where('idCuestionario', $cuestionarioVersion->idCuestionario)
        ->where('fechaBaja', null)
        ->orderBy('id')
        ->first();


      $datace['estadoAoI']            = False;
      if ($cambiarestado) {
        DB::table('CuestionarioVersion')->where('id', $cambiarestado->id)
          ->update($datace);
      }
    }
    if ($request->estadoSimulacion == "on") {
      $data['activoSimulacion'] = true;
    } else {
      $data['activoSimulacion'] = false;
    }

    if ($data['activoSimulacion']  == true) {

      $cambiarestadoSimulacion = DB::table('CuestionarioVersion')
        ->where('activoSimulacion', 1)
        ->where('idCuestionario', $cuestionarioVersion->idCuestionario)
        ->where('fechaBaja', null)
        ->orderBy('id')
        ->first();


      $dataceSimulacion['activoSimulacion']            = False;
      if ($cambiarestadoSimulacion) {
        DB::table('CuestionarioVersion')->where('id', $cambiarestadoSimulacion->id)
          ->update($dataceSimulacion);
      }
    }

    DB::table('CuestionarioVersion')
      ->where('id', $request->idCuestionarioVersion)
      ->update($data);


    $versiones = DB::table('CuestionarioVersion')
      ->where('idCuestionario', $request->idCuestionario)
      ->where('fechaBaja', null)->get();

    $primeraversioncuestionario = 0;

    return view('backend.nuevoCuestionario.indexVersiones', [
      'cuestionariosVersion' => $versiones, 'idCuestionario' => $request->idCuestionario,
      'primeraversioncuestionario' => $primeraversioncuestionario,
    ]);
  }

  public function editarPregunta($id)
  {

    $pregunta = DB::table('Pregunta')
      ->where('id', $id)->first();

    $tema = DB::table('Tema')->where('id', $pregunta->idTema)->where('fechaBaja', null)->first();
    $tiposPregunta = DB::table('TipoPregunta')->get();

    $gruposEntidad = DB::table('GrupoEntidad')->get();

    $categoriasEntidad = DB::table('CategoriaEntidad')->get();

    $preguntas = DB::table('Pregunta')
      ->select(
        'Pregunta.id AS id',
        'Pregunta.pregunta AS pregunta',
        'Pregunta.numero AS numero'
      )->where('idTema', $tema->id)
      ->where('fechaBaja', null)
      ->get();

    $preguntaNivel = DB::table('PreguntaNivel')->where('idPregunta', $id)->get();

    foreach ($gruposEntidad as $keyGrupo => $grupo) {
      $coincidenciaEncontrada = false;

      foreach ($preguntaNivel as $keyNivel => $nivel) {
        if ($grupo->id == $nivel->idGrupoEntidad) {
          $coincidenciaEncontrada = true;
          break;
        }
      }

      if (!$coincidenciaEncontrada) {
        // Crear un nuevo arreglo asociativo con los valores
        $nuevoNivel = [
          'idPregunta' => $id,
          'idGrupoEntidad' => $grupo->id,
          'idCategoriaEntidad' => 1,
          'idNivel' => 0,
        ];

        // Convertir el arreglo en un objeto
        $nuevoNivel = (object)$nuevoNivel;

        // Agregar el nuevo objeto a $preguntaNivel para categoria pequeña
        $preguntaNivel[] = $nuevoNivel;

        $nuevoNivel = [
          'idPregunta' => $id,
          'idGrupoEntidad' => $grupo->id,
          'idCategoriaEntidad' => 2,
          'idNivel' => 0,
        ];

        // Convertir el arreglo en un objeto
        $nuevoNivel = (object)$nuevoNivel;

        // Agregar el nuevo objeto a $preguntaNivel para categoria mediana
        $preguntaNivel[] = $nuevoNivel;

        $nuevoNivel = [
          'idPregunta' => $id,
          'idGrupoEntidad' => $grupo->id,
          'idCategoriaEntidad' => 3,
          'idNivel' => 0,
        ];

        // Convertir el arreglo en un objeto
        $nuevoNivel = (object)$nuevoNivel;

        // Agregar el nuevo objeto a $preguntaNivel para categoria grande
        $preguntaNivel[] = $nuevoNivel;
      }
    }



    return view('backend.nuevoCuestionario.editarPregunta', [
      'pregunta' => $pregunta,
      'tema' => $tema,
      'tiposPregunta' => $tiposPregunta,
      'preguntas' => $preguntas,
      'gruposEntidad' => $gruposEntidad,
      'categoriasEntidad' => $categoriasEntidad,
      'preguntaNivel' => $preguntaNivel
    ]);
  }

  public function editarPreguntaSave(Request $request, ArchivoNombreCargadoService $serviceNombre)
  {


    $idPregunta = DB::table('Pregunta')
      ->where('numero', $request->numero)
      ->where('fechaBaja', null)
      ->first();
    $idCuestionarioVersion = DB::table('Tema')
      ->where('id', $request->idTema)
      ->where('fechaBaja', null)
      ->first();

    if ($request->pdf) {
      $dataPregunta['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Pregunta', 'Pregunta', 'pdf');
    }

    $dataPregunta['idCuestionarioVersion'] = $idCuestionarioVersion->idCuestionarioVersion;
    $dataPregunta['numero'] = $request->numero;
    $dataPregunta['idPreguntaPadre'] = $request->idPreguntaPadre;
    $dataPregunta['idTema'] = $request->idTema;
    $dataPregunta['pregunta'] = $request->pregunta;
    $dataPregunta['idTipoPregunta'] = $request->idTipoPregunta;
    $dataPregunta['respuestaDisparadorSubpregunta'] = $request->respuestaDisparadorSubpregunta;
    $dataPregunta['impactoNivelAvance'] = $request->impactoNivelAvance;
    $dataPregunta['requiereEvidencia'] = $request->requiereEvidencia;
    $dataPregunta['opcionesSugeridas'] = $request->opcionesSugeridas;
    $dataPregunta['cantidadMesesVencimiento'] = $request->cantidadMesesVencimiento;
    $dataPregunta['fechaAlta'] =  date("Y-m-d");
    $dataPregunta['nombrePDF'] = $request->nombrePdf;

    try {

      DB::table('Pregunta')->where('id', $idPregunta->id)->update($dataPregunta);
    } catch (\Throwable $t) {
      echo ($t);
    }

    $cantidad_GrupoEntidad = DB::table('GrupoEntidad')->count('id');


    $cantidad_CategoriaEntidad = DB::table('CategoriaEntidad')->count('id');

    $idPregunta = DB::table('Pregunta')
      ->where('numero', $request->numero)
      ->where('fechaBaja', null)
      ->first();

    for ($i = 1; $i <= $cantidad_GrupoEntidad; $i++) {
      for ($j = 1; $j <= $cantidad_CategoriaEntidad; $j++) {
        $imprimir = "opcionImpacta_" . $i . "_" . $j;

        $dataOpcionImpacta['idNivel'] = $request->$imprimir;

        try {
          if (DB::table('PreguntaNivel')->where('idPregunta', $idPregunta->id)->where('idGrupoEntidad', $i)->where('idCategoriaEntidad', $j)->first()) {

            DB::table('PreguntaNivel')
              ->where('idPregunta', $idPregunta->id)
              ->where('idGrupoEntidad', $i)
              ->where('idCategoriaEntidad', $j)
              ->update($dataOpcionImpacta);
          } else {
           
            if ($request->$imprimir != 0) {
              $dataNuevaOpcionImpacta['idPregunta'] = $idPregunta->id;
              $dataNuevaOpcionImpacta['idGrupoEntidad'] = $i;
              $dataNuevaOpcionImpacta['idCategoriaEntidad'] = $j;
              $dataNuevaOpcionImpacta['idNivel'] = $request->$imprimir;

              DB::table('PreguntaNivel')
                ->insert($dataNuevaOpcionImpacta);
            }
          }
        } catch (\Throwable $t) {
          echo $t;
        }
      }
    }


    $preguntas = DB::table('Pregunta')
      ->where('idTema', $request->idTema)
      ->where('fechaBaja', null)
      ->get();

    $tema = DB::table('Tema')
      ->where('id', $request->idTema)
      ->where('fechaBaja', null)
      ->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();



    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntas', [
      'preguntas' => $preguntas, 'idTema' => $tema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado->estadoAoI
    ]);
  }
  public function editarTema($id)
  {

    $tema = DB::table('Tema')
      ->where('id', $id)
      ->where('fechaBaja', null)
      ->first();

    $cuestionarioVersion = DB::table('CuestionarioVersion')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();

    $cuestionario = DB::table('Cuestionario')
      ->where('id', $cuestionarioVersion->idCuestionario)
      ->where('fechaBaja', null)
      ->first();


    return view('backend.nuevoCuestionario.editarTema', [
      'tema' => $tema, 'cuestionarioVersion' => $cuestionarioVersion, 'cuestionario' => $cuestionario
    ]);
  }

  public function editarTemaSave(Request $request)
  {

    $dataTema['orden'] = $request->orden;
    $dataTema['descripcion'] = $request->descripcion;


    try {

      DB::table('Tema')->where('id', $request->id)->update($dataTema);
    } catch (\Throwable $t) {
      echo ($t);
    }

    $tema = DB::table('Tema')
      ->where('id', $request->id)
      ->where('fechaBaja', null)
      ->first();


    $idCuestionarioVolver = DB::table('CuestionarioVersion')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();

    $temas = DB::table('Tema')
      ->where('idCuestionarioVersion', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->get();

    $cuestionarioVersionEstado = $idCuestionarioVolver->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemas', [
      'temas' => $temas, 'idCuestionarioVolver' => $idCuestionarioVolver,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function editarOpcion($id)
  {

    $opcion = DB::table('PreguntaOpcion')
      ->where('id', $id)
      ->where('fechaBaja', null)
      ->first();


    $pregunta = DB::table('Pregunta')
      ->where('id', $opcion->idPregunta)
      ->where('fechaBaja', null)
      ->first();

    return view('backend.nuevoCuestionario.editarTemasPreguntasOpciones', [
      'opcion' => $opcion, 'pregunta' => $pregunta
    ]);
  }

  public function editarOpcionSave(Request $request)
  {
    $dataopcion['orden'] = $request->orden;
    $dataopcion['descripcion'] = $request->descripcion;

    try {

      DB::table('PreguntaOpcion')->where('id', $request->id)->update($dataopcion);
    } catch (\Throwable $t) {
      echo ($t);
    }
    $opciones = DB::table('PreguntaOpcion')
      ->where('idPregunta', $request->idPregunta)
      ->where('fechaBaja', null)
      ->get();

    $tema =  DB::table('Pregunta')
      ->select('idTema')
      ->where('id', $request->idPregunta)
      ->where('fechaBaja', null)->first();

    $pregunta = DB::table("Pregunta")
      ->where('id', $request->idPregunta)
      ->where('fechaBaja', null)
      ->first();
    $tema1 = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema1->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpciones', [
      'opciones' => $opciones, 'idPregunta' => $request->idPregunta,
      'idTema' => $tema->idTema, 'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function editarOpcionImpacta($id)
  {

    $opcionImpacta = DB::table('OpcionPreguntaImpacta')
      ->where('id', $id)
      ->where('fechaBaja', null)
      ->first();


    $pregunta = DB::table('Pregunta')
      ->where('id', $opcionImpacta->idPregunta)
      ->where('fechaBaja', null)
      ->first();

    return view('backend.nuevoCuestionario.editarTemasPreguntasOpcionesImpactan', [
      'opcion' => $opcionImpacta, 'pregunta' => $pregunta, 'idPregunta' => $opcionImpacta->idPregunta
    ]);
  }

  public function editarOpcionImpactaSave(Request $request)
  {


    if ($request->impacta == "SI") {
      $dataopcionimpacta['opcion'] = "SI";
    }
    if ($request->impacta == "NO") {
      $dataopcionimpacta['opcion'] = "NO";
    }
    if ($request->impacta == "NO APLICA") {
      $dataopcionimpacta['opcion'] = "NO APLICA";
    }
    try {

      DB::table('OpcionPreguntaImpacta')->where('id', $request->id)->update($dataopcionimpacta);
    } catch (\Throwable $t) {
      echo ($t);
    }
    $opciones = DB::table('OpcionPreguntaImpacta')
      ->where('idPregunta', $request->idPregunta)
      ->where('fechaBaja', null)
      ->get();

    $tema = DB::table('Pregunta')
      ->select('idTema')
      ->where('id', $request->idPregunta)
      ->where('fechaBaja', null)
      ->first();
    $pregunta = DB::table("Pregunta")
      ->where('id', $request->idPregunta)
      ->where('fechaBaja', null)
      ->first();
    $tema1 = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema1->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpcionesImpactan', [
      'opciones' => $opciones, 'idPregunta' => $request->idPregunta, 'idTema' => $tema->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  //funciones para borrar 
  public function borrarOpciones($id)
  {
    $opcionesPregunta = DB::table('PreguntaOpcion')
      ->join('Pregunta', 'PreguntaOpcion.idPregunta', '=', 'Pregunta.id')
      ->select('PreguntaOpcion.id as id')
      ->where('idPregunta', $id)
      ->get();
    //itero sobre las opciones para borrarlas
    foreach ($opcionesPregunta as $key => $opcionPregunta) {
      DB::table('PreguntaOpcion')->where('id', $opcionPregunta->id)->delete();
    }
  }

  public function borrarOpcionesImpactan($id)
  {
    $opcionesImpactan = DB::table('OpcionPreguntaImpacta')
      ->join('Pregunta', 'OpcionPreguntaImpacta.idPregunta', '=', 'Pregunta.id')
      ->select('OpcionPreguntaImpacta.id as id')
      ->where('idPregunta', $id)
      ->get();
    //itero sobre las opciones para borrarlas
    foreach ($opcionesImpactan as $key => $opcionImpacta) {
      DB::table('OpcionPreguntaImpacta')->where('id', $opcionImpacta->id)->delete();
    }
  }

  public function borrarNivelesPregunta($id)
  {
    $impactosPorNivel = DB::table('PreguntaNivel')
      ->join('Pregunta', 'PreguntaNivel.idPregunta', '=', 'Pregunta.id')
      ->select('PreguntaNivel.id as id')
      ->where('idPregunta', $id)
      ->get();
    //itero sobre los nivelees para borrarlos
    foreach ($impactosPorNivel as $key => $impactoNivel) {
      DB::table('PreguntaNivel')->where('id', $impactoNivel->id)->delete();
    }
  }

  public function borrarPreguntas($id)
  {
    $preguntasTema = DB::table('Pregunta')->where('Pregunta.idTema', $id)->orderBy('id', 'desc')->get();
    //luego opciones y opciones impacta iterando sobre las preguntas
    foreach ($preguntasTema as $key => $preguntaTema) {

      //borro opciones y opciones impacta
      $this->borrarOpciones($preguntaTema->id);

      //luego borron opciones impacta
      //obtengo las opciones que impactan de la pregunta
      $this->borrarOpcionesImpactan($preguntaTema->id);

      //borro niveles
      $this->borrarNivelesPregunta($preguntaTema->id);

      //borro pregunta
      DB::table('Pregunta')->where('id', $preguntaTema->id)->delete();
    }
  }

  public function borrarTemas($id)
  {

    //cuando ingresa el id de un tema, llamo a borrar las preguntas de ese tema
    $this->borrarPreguntas($id);

    //borro tema
    DB::table('Tema')->where('id', $id)->delete();
  }

  public function borrarPresentaciones($id)
  {
    $presentaciones = DB::table('Presentacion')->where('idCuestionarioVersion', $id)->get();

    if (!empty($presentaciones)) {
      foreach ($presentaciones as $key => $presentacion) {
        try {
          DB::table('Presentacion')->where('id', $presentacion->id)->delete();
        } catch (\Error $e) {
          $success = false;

          $message = "Error al borrar el cuestionario - " . $e;
        }
      }
    }
  }
  ////// BORRAR

  public function destroyCuestionario($id)
  {
    try {
      $oldOrder = DB::table('Cuestionario')->select('descripcion')->where('id', $id)->first();

      $data['estadoAoI']    = 0;
      $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

      DB::table('Cuestionario')->where('id', $id)->update($data);

      DB::commit();

      LogActivity::addToLog('Cuestionario - Se dió de baja el cuestionario ' . $oldOrder->descripcion);

      $success = true;

      $message = "Cuestionario borrado con éxito";
    } catch (\Error $e) {
      $success = false;

      $message = "Error al borrar el cuestionario";
    }
    // $cuestionarios=DB::table('Cuestionario')->where('fechaBaja',null)->get();

    return redirect()->route('nuevoCuestionario.index')
      ->with('success', 'El registro se ha borrado con éxito');
  }

  public function destroyCuestionarioVersion($id)
  {
    $oldOrder = DB::table('CuestionarioVersion')->where('id', $id)->where('fechaBaja', null)->first();
    if (!empty($oldOrder)) {
      try {

        //me traigo todos los temas de la version
        $temas = DB::table('Tema')->where('idCuestionarioVersion', $id)->get();
        foreach ($temas as $key => $tema) {
          //por cada tema llamo a borrar temas
          $this->borrarTemas($tema->id);
        }

        //tengo que validar que no tenga una presentacion con este cuestioanrio version, si es asi, la borro (esto solo va a pasar cuando no este activo en acceso)
        $this->borrarPresentaciones($id);

        //borro la version
        DB::table('CuestionarioVersion')->where('id', $id)->delete();
        DB::commit();
        LogActivity::addToLog('CuestionarioVersion - Se dió de baja la versión del cuestionario ' . $oldOrder->descripcion);
        $success = true;

        $message = "Cuestionario borrado con éxito";
        $versiones = DB::table('CuestionarioVersion')->where('idCuestionario', $oldOrder->idCuestionario)->where('fechaBaja', null)->get();
        $versionescount = DB::table('CuestionarioVersion')->where('idCuestionario', $oldOrder->idCuestionario)->where('fechaBaja', null)->count();

        if ($versionescount == 0) {
          $primeraversioncuestionario = 1;
        } else {
          $primeraversioncuestionario = 0;
        }
      } catch (\Error $e) {
        $success = false;

        $message = "Error al borrar el cuestionario";
      }
    } else {
      $primeraversioncuestionario = 1;
    }

    return view('backend.nuevoCuestionario.indexVersiones', [
      'primeraversioncuestionario' => $primeraversioncuestionario,
      'idCuestionario' => $oldOrder->idCuestionario,
      'cuestionariosVersion' => $versiones
    ]);
  }

  public function destroyTema($id)
  {
    $oldOrder = DB::table('Tema')->where('id', $id)->where('fechaBaja', null)->first();
    //primero obtengo las preguntas del tema
    //las ordeno por id de forma descendente para no tener problemas con las preguntas que tienen idPreguntaPadre

    $this->borrarTemas($id);

    LogActivity::addToLog('Tema - Se dió de baja el tema de forma permanente ' . $oldOrder->descripcion);

    $temas = DB::table('Tema')->where('idCuestionarioVersion', $oldOrder->idCuestionarioVersion)
      ->where('fechaBaja', null)->get();

    $idCuestionarioVolver = DB::table('CuestionarioVersion')->where('id', $oldOrder->idCuestionarioVersion)->where('fechaBaja', null)->first();
    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $idCuestionarioVolver->id)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;
    return view('backend.nuevoCuestionario.indexVersionesTemas', [
      'temas' => $temas, 'idCuestionarioVolver' => $idCuestionarioVolver,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function destroyPregunta($id)
  {
    $oldOrder = DB::table('Pregunta')->where('id', $id)
      ->where('fechaBaja', null)->first();
    //primero borro las opciones
    //obtengo las opciones de la pregunta
    $opcionesPregunta = DB::table('PreguntaOpcion')
      ->join('Pregunta', 'PreguntaOpcion.idPregunta', '=', 'Pregunta.id')
      ->select('PreguntaOpcion.id as id')
      ->where('idPregunta', $id)
      ->get();
    //itero sobre las opciones para borrarlas
    foreach ($opcionesPregunta as $key => $opcionPregunta) {
      DB::table('PreguntaOpcion')->where('id', $opcionPregunta->id)->delete();
    }
    //luego borron opciones impacta
    //obtengo las opciones que impactan de la pregunta
    $opcionesImpactan = DB::table('OpcionPreguntaImpacta')
      ->join('Pregunta', 'OpcionPreguntaImpacta.idPregunta', '=', 'Pregunta.id')
      ->select('OpcionPreguntaImpacta.id as id')
      ->where('idPregunta', $id)
      ->get();
    //itero sobre las opciones para borrarlas
    foreach ($opcionesImpactan as $key => $opcionImpacta) {
      DB::table('OpcionPreguntaImpacta')->where('id', $opcionImpacta->id)->delete();
    }

    //luego borro los impactos por nivel
    //obteengo todos los impactos por nivel de la pregunta
    $impactosPorNivel = DB::table('PreguntaNivel')
      ->join('Pregunta', 'PreguntaNivel.idPregunta', '=', 'Pregunta.id')
      ->select('PreguntaNivel.id as id')
      ->where('idPregunta', $id)
      ->get();
    //itero sobre los nivelees para borrarlos
    foreach ($impactosPorNivel as $key => $impactoNivel) {
      DB::table('PreguntaNivel')->where('id', $impactoNivel->id)->delete();
    }
    //antes de borrar la pregunta tengo que ver si tiene alguna hija
    $preguntasHijas = DB::table('Pregunta')->select('id')->where('idPreguntaPadre', $id)->get();
    //itero sobre preguntas hijas y actualizo su idPreguntaPadre a null
    foreach ($preguntasHijas as $key => $preguntaHija) {
      $data['idPreguntaPadre'] = NULL;

      DB::table('Pregunta')->where('id', $preguntaHija->id)->update($data);
    }
    //una vez que borra las opciones y los niveles puedo borrar la pregunta
    DB::table('Pregunta')->where('id', $id)->delete();

    LogActivity::addToLog('Pregunta - Se dió de baja la pregunta ' . $oldOrder->pregunta);

    $preguntas = DB::table('Pregunta')->where('idTema', $oldOrder->idTema)
      ->where('fechaBaja', null)->get();

    $tema = DB::table('Tema')->where('id', $oldOrder->idTema)
      ->where('fechaBaja', null)->first();


    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->where('id', $tema->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersion = $cuestionarioVersionEstado;
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntas', [
      'preguntas' => $preguntas, 'idTema' => $tema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado,
      'idCuestionarioVolver' => $cuestionarioVersion
    ]);
  }

  public function destroyOpcion($id)
  {
    $oldOrder = DB::table('PreguntaOpcion')->where('id', $id)->first();

    DB::table('PreguntaOpcion')->where('id', $id)->delete();

    LogActivity::addToLog('PreguntaOpcion - Se dió de baja permanente la opcion ' . $oldOrder->descripcion);

    $opciones = DB::table('PreguntaOpcion')->where('idPregunta', $oldOrder->idPregunta)
      ->where('fechaBaja', null)->get();

    $pregunta = DB::table("Pregunta")->where('id', $oldOrder->idPregunta)
      ->where('fechaBaja', null)->first();


    $tema1 = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema1->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;

    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpciones', [
      'opciones' => $opciones, 'idPregunta' => $oldOrder->idPregunta, 'idTema' => $pregunta->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }

  public function destroyOpcionImpacta($id)
  {
    $oldOrder = DB::table('OpcionPreguntaImpacta')
      ->where('id', $id)
      ->where('fechaBaja', null)->first();

    DB::table('OpcionPreguntaImpacta')->where('id', $id)->delete();

    LogActivity::addToLog('OpcionPreguntaImpacta - Se dió de baja permanente la opcionimapacta ' . $oldOrder->opcion);

    $opcionesImpactan = DB::table('OpcionPreguntaImpacta')
      ->where('idPregunta', $oldOrder->idPregunta)
      ->where('fechaBaja', null)
      ->get();

    $pregunta = DB::table("Pregunta")
      ->where('id', $oldOrder->idPregunta)
      ->where('fechaBaja', null)
      ->first();

    $tema1 = DB::table('Tema')->where('id', $pregunta->idTema)
      ->where('fechaBaja', null)->first();

    $cuestionarioVersionEstado = DB::table('CuestionarioVersion')
      ->select('estadoAoI')
      ->where('id', $tema1->idCuestionarioVersion)
      ->where('fechaBaja', null)
      ->first();
    $cuestionarioVersionEstado = $cuestionarioVersionEstado->estadoAoI;


    return view('backend.nuevoCuestionario.indexVersionesTemasPreguntasOpcionesImpactan', [
      'opciones' => $opcionesImpactan, 'idPregunta' => $oldOrder->idPregunta, 'idTema' => $pregunta->idTema,
      'cuestionarioVersionEstado' => $cuestionarioVersionEstado
    ]);
  }
}
