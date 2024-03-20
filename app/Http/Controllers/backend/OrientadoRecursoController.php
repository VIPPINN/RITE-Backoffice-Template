<?php

namespace App\Http\Controllers\backend;

use DB;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Models\OrientadoRecurso;
use App\Http\Controllers\Controller;

class OrientadoRecursoController extends Controller
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
        $orientadoRecurso = $filtro->filtroEstado($estado, 'orientadoRecurso');

        return view('backend.orientadoRecurso.index', [
            'orientadoRecurso' => $orientadoRecurso
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orientadoRecurso = DB::table('orientadoRecurso')->paginate(10);
        
        LogActivity::addToLog('Orientado Recurso - Listado.');

        return view('backend.orientadoRecurso.index', [
            'orientadoRecurso' => $orientadoRecurso
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.orientadoRecurso.create');
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
            $request->validate(['titulo' => 'required']);

            $data['titulo']      = $request->input("titulo");
            $data['descripcion'] = $request->input("editor");
            $data['estado']      = ($request->status == 'on') ? 1 : 0;
            $data['fechaAlta']   = DB::raw('CURRENT_TIMESTAMP');

            DB::table('orientadoRecurso')->insert($data);

            LogActivity::addToLog('Orientado Recurso - Se ha agregado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('orientadoRecurso.index')
                ->with('success', 'La pregunta fue creada satisfactoriamente.');
            }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('orientadoRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrientadoRecurso  $orientadoRecurso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orientadoRecurso = DB::table('orientadoRecurso')->where('id', $id)->first();

        return view('backend.orientadoRecurso.show')
            ->with('orientadoRecurso', $orientadoRecurso);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrientadoRecurso  $orientadoRecurso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orientadoRecurso = DB::table('orientadoRecurso')->where('id', $id)->first();

        return view('backend.orientadoRecurso.edit')
            ->with('orientadoRecurso', $orientadoRecurso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrientadoRecurso  $orientadoRecurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try 
        {
            $request->validate(['titulo' => 'required']);

            $data['titulo']      = $request->input("titulo");
            $data['descripcion'] = $request->input("editor");
            $data['estado']      = ($request->status == 'on') ? 1 : 0;
            
            DB::table('orientadoRecurso')->where('id', $id)->update($data);

            LogActivity::addToLog('Orientado Recurso - Se ha actualizado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('orientadoRecurso.index')
                ->with('success', 'La pregunta fue creada satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('orientadoRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrientadoRecurso  $orientadoRecurso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('orientadoRecurso')->where('id', $id)->update($data);
        $element = DB::table('orientadoRecurso')->where('id', $id)->first();
        
        LogActivity::addToLog('Orientado Recurso - Se dió de baja: '.$element->titulo);

        return redirect()->route('orientadoRecurso.index')
            ->with('success', 'La pregunta se ha borrado con éxito');
    }
}
