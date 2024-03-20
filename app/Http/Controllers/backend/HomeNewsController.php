<?php

namespace App\Http\Controllers\backend;

use DB;
use Image;
use Carbon\Carbon;
use App\Models\HomeNews;
use Illuminate\Support\Str;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Services\FormatearFecha;
use App\Http\Controllers\Controller;
use App\Services\UpdateOrderDatabase;
use App\Http\Requests\UpdateHomeNewsRequest;
use App\Services\ArchivoNombreCargadoService;

class HomeNewsController extends Controller
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
        $news = $filtro->filtroEstadoOrdenado($estado, 'Novedades');

        return view('backend.news.index', [
            'news' => $news
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = DB::table('Novedades')
            ->orderBy('orden')
            ->where('estado',1)
            ->paginate(10);
        
           
        LogActivity::addToLog('Novedades - Listado');
		
      return view('backend.news.index', [
        'news' => $news
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ultimoNumeroDeOrden = DB::table('Novedades')
                                ->select('orden')
                                ->where('estado',1)
                                ->orderBy('orden', 'desc')
                                ->first();
        
        return view('backend.news.create', [
            'ultimoNumeroDeOrden' => $ultimoNumeroDeOrden == null ? 0 : $ultimoNumeroDeOrden->orden
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateHomeNewsRequest $request, HomeNews $novedades, ArchivoNombreCargadoService $serviceNombre)
    {
       
        DB::beginTransaction();
        try 
        {
            $objVerificoOrden = new UpdateOrderDatabase();

            $checked = $objVerificoOrden->actualizarOrden(null,'Novedades', $request->estado, $request->orden);

            $data=array();
            if(empty($request->file('image')))
            {
                $request->validate(['file' => 'required'],['file.required' => '(*) Debe cargar una imagen. ']);
            } 
            else
            {
                $data['imagenPublicacion'] = $serviceNombre->GenerarNombreYMiniaturaDeImagen($request->file('image'), 'news', 'Novedades', 'imagenPublicacion');
            }
            $data['titulo']            = $request->title;
            $data['slug']              = $request->slug;
            $data['descripcionLarga']  = $request->txt_large;
            $data['descripcionCorta']  = $request->txt_short;
            $formatoFecha              = new FormatearFecha;
            $data['fechaPublicacion']  = $formatoFecha->DiaMesAnioToAnioMesDia($request->fecha);
            $data['orden']             = $checked != 0 ? $checked : $request->orden;
            $data['estado']            = $request->estado;
            $data['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');
            
            DB::table('Novedades')->insert($data);

            LogActivity::addToLog('Novedades - Agregada la nota '.$request->title);
        
            DB::commit();

            return redirect()->route('news.index')
                            ->with('success','La noticia fue creada correctamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('news.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeNews  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

        $news = DB::table('Novedades')->where('id', $id)->first();

        LogActivity::addToLog('Novedades - Viendo '.$news->titulo);

        return view('backend.news.show')
                  ->with('news', $news);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeNews  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = DB::table('Novedades')->where('id', $id)->first();

        return view('backend.news.edit')
                  ->with('news', $news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeNews  $news
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeNewsRequest $request, ArchivoNombreCargadoService $serviceNombre, HomeNews $novedades, $id)
    {
        DB::beginTransaction();
        try 
        {
            $objVerificoOrden = new UpdateOrderDatabase();

            $checked = $objVerificoOrden->actualizarOrden($id,'Novedades', $request->estado, $request->orden);

            $data=array();
            $data['titulo']            = $request->title;
            $data['descripcionLarga']  = $request->txt_large;
            $data['descripcionCorta']  = $request->txt_short;
            $formatoFecha              = new FormatearFecha;
            $data['fechaPublicacion']  = $formatoFecha->DiaMesAnioToAnioMesDia($request->fecha);
            $data['orden']             = $checked != 0 ? $checked : $request->orden;
            if(!empty($request->file('image'))) $data['imagenPublicacion'] = $serviceNombre->GenerarNombreYMiniaturaDeImagen($request->file('image'), 'news', 'Novedades', 'imagenPublicacion', $id);
            $data['estado']            = $request->estado;
            $data['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');
            
            DB::table('Novedades')->where('id', $id)->update($data);

            LogActivity::addToLog('Novedades - Actualizada la nota '.$request->title);
        
            DB::commit();

            return redirect()->route('news.index')
                            ->with('success','La noticia fue creada correctamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('news.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeNews  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        DB::beginTransaction();
        try 
        {
            $oldOrder = DB::table('Novedades')->select('orden', 'titulo')->where('id',$id)->first();

           
            $data=array();
            $data['estado']    = 0;
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
            
            DB::table('Novedades')->where('id', $id)->update($data);

            LogActivity::addToLog('Novedades - Se dió de baja la pregunta '.$oldOrder->titulo);
        
            DB::commit();

            return redirect()->route('news.index')
                             ->with('success', 'El registro se ha borrado con éxito');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('news.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }
}
