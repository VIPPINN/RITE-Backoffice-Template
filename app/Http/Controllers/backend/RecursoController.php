<?php

namespace App\Http\Controllers\backend;

use DB;
use App\Models\Recurso;
use App\Models\TipoRecurso;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\OrigenRecurso;
use App\Services\FiltroService;
use App\Models\OrientadoRecurso;
use App\Models\orientado_recursos;
use App\Http\Controllers\Controller;

class RecursoController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return filtered list of resources
     */
    public function filtro($estado)
    {
        if(!is_numeric($estado)) return abort(404);
        
        $filtro = new FiltroService();
        $recurso2  = $filtro->filtroEstadoRecurso($estado);

        $orientado = DB::table('orientado_recursos')
            ->join('recursos', 'recursos.id', '=', 'orientado_recursos.idRecurso')
            ->join('orientadoRecurso', 'orientadoRecurso.id', '=', 'orientado_recursos.idOrientadoRecurso')
            ->select(
                'orientadoRecurso.titulo as orientadoTitulo',
                'orientadoRecurso.id as orientadoId',
                'recursos.id as recursoId'
            )
            ->get(); 

        return view('backend.recurso.index', [
            'recurso' => $recurso2,
            'orientado' => $orientado
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orientado = DB::table('orientado_recursos')
            ->join('recursos', 'recursos.id', '=', 'orientado_recursos.idRecurso')
            ->join('orientadoRecurso', 'orientadoRecurso.id', '=', 'orientado_recursos.idOrientadoRecurso')
            ->select(
                'orientadoRecurso.titulo as orientadoTitulo',
                'orientadoRecurso.id as orientadoId',
                'recursos.id as recursoId'
            )
            ->get();

        $recurso2 = Recurso::filter()
            ->join('tipoRecurso', 'tipoRecurso.id', '=', 'recursos.idTipoRecurso')
            ->join('origenRecurso', 'origenRecurso.id', '=', 'recursos.idOrigenRecurso')
            ->join('temaRecurso','temaRecurso.id','=','recursos.idTemaRecurso')
            ->select(
                'recursos.id AS id',
                'recursos.titulo AS titulo',
                'recursos.descripcion AS descripcion',
                'recursos.enlaceDescarga AS descarga',
                'recursos.estado AS status',
                'tipoRecurso.titulo AS tipoRecursoTitulo',
                'origenRecurso.titulo AS origenRecursoTitulo',
                'temaRecurso.titulo AS temaRecursoTitulo'
            )
            ->where('recursos.estado', 1)
            ->paginate(10);

        LogActivity::addToLog('Recursos - Listado');

        return view('backend.recurso.index', [
            'recurso' => $recurso2,
            'orientado' => $orientado

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $origenRecurso = DB::table('origenRecurso')->get();

        $orientadoRecurso = DB::table('orientadoRecurso')->get();

        $tipoRecurso = DB::table('tipoRecurso')->get();

        $temaRecurso = DB::table('temaRecurso')->get();

        return view('backend.recurso.create', [
            'origenRecurso' => $origenRecurso,
            'orientadoRecurso' => $orientadoRecurso,
            'tipoRecurso' => $tipoRecurso,
            'temaRecurso' => $temaRecurso,
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
        $request->validate([
            'titulo'        => 'required',
            'origen'        => 'required',
            'descargarLink' => 'required'
        ]);

        $data['titulo']              = $request->input("titulo");
        $data['descripcion']         = $request->input("editor");
        $data['enlaceDescarga']        = $request->descargarLink;
        $data['idTipoRecurso']       = $request->tipo;

        $data['idOrigenRecurso']     = $request->origen;

        $data['idTemaRecurso']       = $request->tema;


        $data['estado'] = ($request->status == 'on') ? 1 : 0;


        $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

        

        DB::table('recursos')->insert($data);

        $recursoId = DB::table('recursos')->select('id')
            ->where('recursos.titulo', $data['titulo'])
            ->get();

        $cantidadOrientado = DB::table('orientadoRecurso')
            ->select('orientadoRecurso.titulo', DB::raw('count(*) as total'))
            ->groupBy('titulo')
            ->get();

        //dd(count($cantidadOrientado));
        for ($i = 0; $i < count($cantidadOrientado); $i++) {
            //dd('orientado'.$i);
            $var = 'orientado' . $i;
            if ($request->$var) {
                $orientacion['idRecurso']    = $recursoId[0]->id;
                $orientacion['idOrientadoRecurso']  = $request->$var;
                DB::table('orientado_recursos')->insert($orientacion);
            }
        }


        LogActivity::addToLog('Recursos - Se ha creado el recurso: '.$data['titulo']);

        return redirect()->route('recurso.index')
            ->with('success', 'La pregunta fue creada satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

        $recurso = DB::table('recursos')->join('tipoRecurso', 'tipoRecurso.id', '=', 'recursos.idTipoRecurso')
            ->join('origenRecurso', 'origenRecurso.id', '=', 'recursos.idOrigenRecurso')
            ->join('temaRecurso','temaRecurso.id','=','recursos.idTemaRecurso')
            ->select(
                'recursos.id AS id',
                'recursos.titulo AS titulo',
                'recursos.descripcion AS descripcion',
                'recursos.enlaceDescarga AS descarga',
                'recursos.estado AS status',
                'tipoRecurso.titulo AS tipoRecursoTitulo',
                'origenRecurso.titulo AS origenRecursoTitulo',
                'temaRecurso.titulo AS temaRecursoTitulo'

            )->where('recursos.id', $id)
            ->get();

        $orientado = DB::table('orientado_recursos')
            ->join('recursos', 'recursos.id', '=', 'orientado_recursos.idRecurso')
            ->join('orientadoRecurso', 'orientadoRecurso.id', '=', 'orientado_recursos.idOrientadoRecurso')
            ->select(
                'orientadoRecurso.titulo as orientadoTitulo',
                'orientadoRecurso.id as orientadoId',
                'recursos.id as recursoId'
            )
            ->get();

        //dd($orientado);
        LogActivity::addToLog('Recursos - Esta visualizando el recurso: '.$recurso->titulo);

        return view('backend.recurso.show', [
            'recurso' => $recurso,
            'orientado' => $orientado

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recurso = DB::table('recursos')->join('tipoRecurso', 'tipoRecurso.id', '=', 'recursos.idTipoRecurso')
            ->join('origenRecurso', 'origenRecurso.id', '=', 'recursos.idOrigenRecurso')
            ->join('temaRecurso','temaRecurso.id','=','recursos.idTemaRecurso')
            ->select(
                'recursos.id AS id',
                'recursos.titulo AS titulo',
                'recursos.descripcion AS descripcion',
                'recursos.enlaceDescarga AS descarga',
                'recursos.estado AS status',
                'tipoRecurso.titulo AS tipoRecursoTitulo',
                'origenRecurso.titulo AS origenRecursoTitulo',
                'temaRecurso.titulo AS temaRecursoTitulo',
                'tipoRecurso.id AS tipoRecursoId',
                'origenRecurso.id AS origenRecursoId',
                'temaRecurso.id AS temaRecursoId'

            )->where('recursos.id', $id)
            ->get();

        $origenRecurso = DB::table('origenRecurso')->get();

        $orientadoRecurso = DB::table('orientadoRecurso')->get();

        $tipoRecurso = DB::table('tipoRecurso')->get();

        $temaRecurso = DB::table('temaRecurso')->get();

        $orientado = DB::table('orientado_recursos')
            ->join('recursos', 'recursos.id', '=', 'orientado_recursos.idRecurso')
            ->join('orientadoRecurso', 'orientadoRecurso.id', '=', 'orientado_recursos.idOrientadoRecurso')
            ->select(
                'orientadoRecurso.titulo as orientadoTitulo',
                'orientadoRecurso.id as orientadoId',
                'recursos.id as recursoId'
            )
            ->where('recursos.id', $id)
            ->get();

        //dd($orientado,$orientadoRecurso);
        return view('backend.recurso.edit', [
            'recurso' => $recurso,
            'origenRecurso' => $origenRecurso,
            'orientadoRecurso' => $orientadoRecurso,
            'tipoRecurso' => $tipoRecurso,
            'temaRecurso' => $temaRecurso,
            'orientado' => $orientado

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',

            'origen' => 'required',
            'descargarLink' => 'required'

        ]);

        $data['titulo']              = $request->input("titulo");
        $data['descripcion']         = $request->input("editor");
        $data['enlaceDescarga']        = $request->descargarLink;
        $data['idTipoRecurso']       = $request->tipo;

        $data['idOrigenRecurso']     = $request->origen;

        $data['idTemaRecurso']       = $request->tema;


        $data['estado'] = ($request->status == 'on') ? 1 : 0;

        

        //Tabla intermedia que relaciona el recurso con la orientacion
        $tablaIntermedia = DB::table('orientado_recursos')
            ->where('idRecurso', '=', $id)
            ->get();

        $cantidadOrientado = DB::table('orientadoRecurso')
            ->select('orientadoRecurso.titulo', DB::raw('count(*) as total'))
            ->groupBy('titulo')
            ->get();

        for ($j = 0; $j < count($tablaIntermedia); $j++) {

            if ($tablaIntermedia[$j]->idRecurso == $id) {

                DB::table('orientado_recursos')
                    ->where('idRecurso', $id)
                    ->delete();
            }
        }

        for ($i = 0; $i < count($cantidadOrientado); $i++) {
            //dd('orientado'.$i);
            $var = 'orientado' . $i;
            if ($request->$var) {
                $orientacion['idRecurso']    = $id;
                $orientacion['idOrientadoRecurso']  = $request->$var;
                DB::table('orientado_recursos')->insert($orientacion);
            }
        }



        LogActivity::addToLog('Recursos - Se ha editado el recurso: '.$data['titulo']);


        DB::table('recursos')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('recurso.index')
            ->with('success', 'La pregunta fue creada satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('recursos')->where('id', $id)->update($data);
        $element = DB::table('recursos')->where('id', $id)->first();
        
        LogActivity::addToLog('Recurso - Dió de baja: '.$element->titulo);

        return redirect()->route('recurso.index')
            ->with('success', 'La pregunta se ha borrado con éxito');
    }
}
