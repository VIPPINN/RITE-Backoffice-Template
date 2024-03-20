<?php

namespace App\Http\Controllers\backend;;

use DB;
use App\Models\Tema;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;

class TemaRecursoController extends Controller
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
        $temaRecurso = $filtro->filtroEstado($estado, 'temaRecurso');

        return view('backend.temaRecurso.index', [
            'temaRecurso' => $temaRecurso
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temaRecurso = DB::table('temaRecurso')->where('estado',1)->paginate(10);
        LogActivity::addToLog('Tema Recurso - Listado.');

        return view('backend.temaRecurso.index', [
            'temaRecurso' => $temaRecurso
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.temaRecurso.create');
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

            $data['titulo']      = $request->input("titulo");
            $data['descripcion'] = $request->input("editor");
            $data['estado']      = ($request->status == 'on') ? 1 : 0;
            $data['fechaAlta']   = DB::raw('CURRENT_TIMESTAMP');

            DB::table('temaRecurso')->insert($data);

            LogActivity::addToLog('Tema Recurso - Se ha agregado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('temaRecurso.index')
                ->with('success', 'El tema fue creado satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('temaRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $temaRecurso = DB::table('temaRecurso')->where('id', $id)->first();

        return view('backend.temaRecurso.show')
            ->with('temaRecurso', $temaRecurso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $temaRecurso = DB::table('temaRecurso')
        ->where('id', $id)
        ->first();

    return view('backend.temaRecurso.edit')
        ->with('temaRecurso', $temaRecurso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            
        ]);

        DB::beginTransaction();
        try 
        {
            $data['titulo'] = $request->input("titulo");
            $data['descripcion'] = $request->input("editor");
            $data['estado'] = ($request->status == 'on') ? 1 : 0;
            
            DB::table('temaRecurso')->where('id', $id)->update($data);

            LogActivity::addToLog('Tema Recurso - Se ha modificado el registro '.$data['titulo']);

            DB::commit();

            return redirect()->route('temaRecurso.index')
                ->with('success', 'El tema fue creado satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('temaRecurso.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('temaRecurso')->where('id', $id)->update($data);
        $element = DB::table('temaRecurso')->where('id', $id)->first();
        
        LogActivity::addToLog('Tema Recurso - Dió de baja: '.$element->titulo);

        return redirect()->route('temaRecurso.index')
            ->with('success', 'El tema se ha borrado con éxito');
    }
}
