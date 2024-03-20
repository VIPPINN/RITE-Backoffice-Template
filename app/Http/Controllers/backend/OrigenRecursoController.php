<?php

namespace App\Http\Controllers\backend;

use DB;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\OrigenRecurso;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;

class OrigenRecursoController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function filtro($estado)
    {
        if(!is_numeric($estado)) return abort(404);
        
        $filtro = new FiltroService();
        $origenRecurso = $filtro->filtroEstado($estado, 'origenRecurso');

        return view('backend.origenRecurso.index', [
            'origenRecurso' => $origenRecurso
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $origenRecurso = DB::table('origenRecurso')->where('estado',1)->paginate(10);
        LogActivity::addToLog('Origen Recurso - Listado.');

        return view('backend.origenRecurso.index', [
            'origenRecurso' => $origenRecurso
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.origenRecurso.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            $data = array();
            $request->validate(['titulo' => 'required']);

            $data['titulo'] = $request->input("titulo");
            $data['descripcion'] = $request->input("editor");
            $data['estado'] = ($request->status == 'on') ? 1 : 0;
            $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('origenRecurso')->insert($data);

            LogActivity::addToLog('Origen Recurso - Se ha agregado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('origenRecurso.index')
                ->with('success', 'El origen fue creada satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('origenRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrigenRecurso  $origenRecurso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $origenRecurso = DB::table('origenRecurso')->where('id', $id)->first();

        return view('backend.origenRecurso.show')
            ->with('origenRecurso', $origenRecurso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrigenRecurso  $origenRecurso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $origenRecurso = DB::table('origenRecurso')->where('id', $id)->first();

    return view('backend.origenRecurso.edit')
        ->with('origenRecurso', $origenRecurso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrigenRecurso  $origenRecurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try 
        {
            $request->validate(['titulo' => 'required']);

            $data['titulo'] = $request->input("titulo");
            $data['descripcion'] = $request->input("editor");
            $data['estado'] = ($request->status == 'on') ? 1 : 0;

            DB::table('origenRecurso')->where('id', $id)->update($data);

            LogActivity::addToLog('Origen Recurso - Se ha modificado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('origenRecurso.index')
                ->with('success', 'La Origen del recurso fue creado satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('origenRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrigenRecurso  $origenRecurso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('origenRecurso')->where('id', $id)->update($data);
        $element = DB::table('origenRecurso')->where('id', $id)->first();
        
        LogActivity::addToLog('Origen Recurso - Dió de baja: '.$element->titulo);

        return redirect()->route('origenRecurso.index')
            ->with('success', 'La origen del Recurso se ha borrado con éxito');
    }
}
