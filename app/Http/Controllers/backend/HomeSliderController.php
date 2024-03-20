<?php

namespace App\Http\Controllers\backend;

use DB;
use Carbon\Carbon;
use App\Models\HomeSlider;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;
use App\Services\UpdateOrderDatabase;
use App\Http\Requests\UpdateCarruselRequest;
use App\Services\ArchivoNombreCargadoService;

class HomeSliderController extends Controller
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
        $sliders = $filtro->filtroEstadoOrdenado($estado, 'Carrusel');

        return view('backend.sliders.index', [
            'sliders' => $sliders
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = DB::table('Carrusel')
                    ->orderBy('orden')
                    ->where('estado',1)
                    ->paginate(10);
        
        LogActivity::addToLog('Carrusel - Listado');

        return view('backend.sliders.index', [
            'sliders' => $sliders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ultimoNumeroDeOrden = DB::table('Carrusel')
                                ->select('orden')
                                ->where('estado',1)
                                ->orderBy('orden', 'desc')
                                ->first();
        return view('backend.sliders.create', [
            'ultimoNumeroDeOrden' => $ultimoNumeroDeOrden == null ? 0 : $ultimoNumeroDeOrden->orden
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateCarruselRequest $request, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try 
        {
            $data=array();
            if($request->imagepc == null)
            {
                $request->validate(['imagepc' => 'required'],['imagepc.required' => '(*) Debe cargar una imagen para el carrusel. ']);
            } 
            else
            {
                $data['enlaceImagenPc'] = $serviceNombre->GenerarNombre($request->imagepc, 'HomeSlider','Carrusel', 'enlaceImagenPc');
            }
        
            $objVerificoOrden = new UpdateOrderDatabase();

            $checked = $objVerificoOrden->actualizarOrden(null,'Carrusel', $request->status, $request->orden);

            $data['titulo']         = $request->title;
            $data['subtitulo']         = $request->subtitle;
            $data['enlace']         = $request->link;
            $data['orden']          = $checked != 0 ? $checked : $request->orden;
            $data['estado']         = $request->status;
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');

            DB::table('Carrusel')->insert($data);

            LogActivity::addToLog('Carrusel - Se ha agregado la imagen '.$request->title.' al carrusel');

            DB::commit();
        
            return redirect()->route('sliders.index')
                            ->with('success','El slider fue creado satisfactoriamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('sliders.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);
        
        //return view('sliders.show', compact('homeslider'));
        $sliders = DB::table('Carrusel')
                              ->where('id', $id)
                              ->first();
                        
        LogActivity::addToLog('Carrusel - Mostrando la imagen '.$sliders->titulo.' del carrusel');

        return view('backend.sliders.show')
                  ->with('sliders', $sliders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sliders = DB::table('Carrusel')
                              ->where('id', $id)
                              ->first();
        
        return view('backend.sliders.edit')
                  ->with('sliders', $sliders);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarruselRequest $request, ArchivoNombreCargadoService $serviceNombre, $id)
    {
        DB::beginTransaction();
        try 
        {
            $data=array();
            if($request->imagepc != null)
            {
                $data['enlaceImagenPc'] = $serviceNombre->GenerarNombre($request->imagepc, 'HomeSlider','Carrusel', 'enlaceImagenPc', $id);
            } 

            $objVerificoOrden = new UpdateOrderDatabase();

            $checked = $objVerificoOrden->actualizarOrden($id,'Carrusel', $request->status, $request->orden);

            $data['titulo']         = $request->title;
            $data['subtitulo']         = $request->subtitle;
            $data['enlace']         = $request->link;
            $data['orden']          = $checked != 0 ? $checked : $request->orden;
            $data['estado']         = $request->status;
            if($request->status == 1) $data['fechaBaja'] = '';

            DB::table('Carrusel')->where('id', $id)->update($data);

            LogActivity::addToLog('Carrusel - Se ha actualizado la imagen '.$request->title.' del carrusel');

            DB::commit();
        
            return redirect()->route('sliders.index')->with('success','El slider fue creado satisfactoriamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('sliders.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeSlider  $homeSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try 
        {
            $oldOrder = DB::table('Carrusel')->select('orden','titulo')->where('id',$id)->first();
            
            $objVerificoOrden = new UpdateOrderDatabase();

            $checked = $objVerificoOrden->actualizarOrden(null,'Carrusel', 0, $oldOrder->orden);

            $data['estado']    = 0;
            $data['orden']     = $checked != 0 ? $checked : $oldOrder->orden;
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('Carrusel')->where('id', $id)->update($data);

            LogActivity::addToLog('Carrusel - Se ha dado de baja la imagen '.$oldOrder->titulo.' del carrusel');

            DB::commit();
    
            return redirect()->route('sliders.index')
                ->with('success', 'La pregunta se ha actualizado con éxito');
    
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('sliders.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }
}
