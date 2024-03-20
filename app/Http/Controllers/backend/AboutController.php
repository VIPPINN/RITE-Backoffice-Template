<?php

namespace App\Http\Controllers\backend;

use DB;
use Carbon\Carbon;
use App\Models\About;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateQueEsRiteRequest;
use App\Services\ArchivoNombreCargadoService;

class AboutController extends Controller
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
        $about = $filtro->filtroEstado($estado, 'QueEsRite');

        return view('backend.about.index', [
            'about' => $about
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(About $about)
    {
        $about = DB::table('QueEsRite')->where('estado',1)->paginate(10);
        LogActivity::addToLog('¿Que es RITE? - Listado.');

        return view('backend.about.index', [
            'about' => $about
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateQueEsRiteRequest $request, About $about, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try 
        {
            $data = array();
            if(empty($request->file))
            {
                $request->validate(['file' => 'required'],['file.required' => '(*) Debe ingresar el archivo PDF. ']);
            } 
            else
            {
                $data['enlacePdf'] = $serviceNombre->GenerarNombre($request->file, 'about', 'QueEsRite', 'enlacePdf');
            }
            $data['titulo']           = $request->titulo;
            $data['descripcionCorta'] = $request->editor_short;
            $data['descripcionLarga'] = $request->editor_large;
            $data['estado']           = $request->estado;
            $data['fechaAlta']        = DB::raw('CURRENT_TIMESTAMP');

           

            DB::table('QueEsRite')->insert($data);

            LogActivity::addToLog('¿Que es RITE? - Se ha agregado el registro '.$data['titulo']);

            DB::commit();

            return redirect()
                ->route('about.index')
                ->with('success', 'El texto about fue creado satisfactoriamente.');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('about.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

        $about = DB::table('QueEsRite')->where('id', $id)->first();
        LogActivity::addToLog('¿Que es RITE? - Viendo '.$about->titulo);

        return view('backend.about.show')
            ->with('about', $about);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = DB::table('QueEsRite')->where('id', $id)->first();

        return view('backend.about.edit')
            ->with('about', $about);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQueEsRiteRequest $request, About $about, ArchivoNombreCargadoService $serviceNombre)
    {   
        DB::beginTransaction();
        try 
        {
            $data = array();
            if(!empty($request->file)) $data['enlacePdf'] = $serviceNombre->GenerarNombre($request->file, 'about', 'QueEsRite', 'enlacePdf', $about->id);
            $data['titulo']           = $request->titulo;
            $data['descripcionCorta'] = $request->editor_short;
            $data['descripcionLarga'] = $request->editor_large;
            $data['estado']           = $request->estado;
            if($request->estado == 1) $data['fechaBaja'] = '';
            
            DB::table('QueEsRite')->where('id', $about->id)->update($data);
            LogActivity::addToLog('¿Que es RITE? - Editado: '.$data['titulo']);

            DB::commit();

            return redirect()->route('about.index')
                ->with('success', 'El about se ha actualizado con éxito');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('about.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('QueEsRite')->where('id', $id)->update($data);
        $element = DB::table('QueEsRite')->where('id', $id)->first();
        
        LogActivity::addToLog('¿Que es RITE? - Dió de baja: '.$element->titulo);

        return redirect()->route('about.index')
            ->with('success', 'El registro se ha borrado con éxito');
    }
}
