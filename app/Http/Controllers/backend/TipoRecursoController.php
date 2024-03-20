<?php

namespace App\Http\Controllers\backend;

use DB;
use App\Models\TipoRecurso;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;

class TipoRecursoController extends Controller
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
        $tipoRecurso = $filtro->filtroEstado($estado, 'tipoRecurso');

        return view('backend.tipoRecurso.index', [
            'tipoRecurso' => $tipoRecurso
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoRecurso = DB::table('tipoRecurso')->paginate(10);
        LogActivity::addToLog('Tipo de Recurso - Listado.');

        return view('backend.tipoRecurso.index', [
            'tipoRecurso' => $tipoRecurso
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tipoRecurso.create');
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

            DB::table('tipoRecurso')->insert($data);

            LogActivity::addToLog('Tipo de Recursos - Se ha agregado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('tipoRecurso.index')
                ->with('success', 'La pregunta fue creada satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('tipoRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

        $tipoRecurso = DB::table('tipoRecurso')->where('id', $id)->first();

        LogActivity::addToLog('Tipo de Recursos - Viendo '.$about->titulo);

        return view('backend.tipoRecurso.show')
            ->with('tipoRecurso', $tipoRecurso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoRecurso = DB::table('tipoRecurso')
        ->where('id', $id)
        ->first();

    return view('backend.tipoRecurso.edit')
        ->with('tipoRecurso', $tipoRecurso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoRecurso  $tipoRecurso
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

            DB::table('tipoRecurso')->where('id', $id)->update($data);

            LogActivity::addToLog('Tipo de Recurso - Se ha modificado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('tipoRecurso.index')
                ->with('success', 'La pregunta fue creada satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('tipoRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
        
        DB::table('tipoRecurso')->where('id', $id)->update($data);
        $element = DB::table('tipoRecurso')->where('id', $id)->first();
        
        LogActivity::addToLog('Tipo de Recurso - Se dió de baja el '.$element->titulo);

        return redirect()->route('tipoRecurso.index')
            ->with('success', 'La pregunta se ha borrado con éxito');
    }
}
