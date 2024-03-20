<?php

namespace App\Http\Controllers\backend;

use DB;
use Carbon\Carbon;
use App\Models\HomeRedes;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;
use App\Services\UpdateOrderDatabase;
use App\Http\Requests\UpdateRedesRequest;
use App\Services\ArchivoNombreCargadoService;

class HomeRedesController extends Controller
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
        $redes = $filtro->filtroEstado($estado, 'RedSocial');

        return view('backend.redes.index', [
            'redes' => $redes
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redes = DB::table('RedSocial')
            ->where('estado',1)
            ->paginate(10);
        
        LogActivity::addToLog('Red Social - Listado');
		
      return view('backend.redes.index', [
        'redes' => $redes
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.redes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateRedesRequest $request, HomeRedes $redes, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try 
        {
            $data=array();
            if(!empty($request->file('image_logo')))
            {
                $data['logotipo'] = $serviceNombre->GenerarNombre($request->file('image_logo'), 'HomeRedes', 'RedSocial', 'logotipo');
            }
            $data['titulo']    = $request->nombre;
            $data['enlace']    = $request->link;
            $data['estado']    = $request->estado;
            $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('RedSocial')->insert($data);

            LogActivity::addToLog('Red Social - Agregada la red social '.$request->nombre);
        
            DB::commit();

            return redirect()->route('redes.index')
                            ->with('success','La noticia fue creada correctamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('redes.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);
        
        $redes = DB::table('RedSocial')->where('id', $id)->first();

        LogActivity::addToLog('Red Social - Agregada la red social '.$redes->titulo);

        return view('backend.redes.show')
                  ->with('redes', $redes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $redes = DB::table('RedSocial')->where('id', $id)->first();

        return view('backend.redes.edit')
                  ->with('redes', $redes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedesRequest $request, ArchivoNombreCargadoService $serviceNombre, HomeRedes $redes, $id)
    {
        DB::beginTransaction();
        try 
        {
            $data=array();
            if(!empty($request->file('image_logo')))
            {
                $data['logotipo'] = $serviceNombre->GenerarNombre($request->file('image_logo'), 'HomeRedes', 'RedSocial', 'logotipo');
            }
            $data['titulo']    = $request->nombre;
            $data['enlace']    = $request->link;
            $data['estado']    = $request->estado;
            $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('RedSocial')->where('id', $id)->update($data);

            LogActivity::addToLog('Red Social - Actualizada la red social '.$request->nombre);
        
            DB::commit();

            return redirect()->route('redes.index')
                            ->with('success','La noticia fue creada correctamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('redes.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try 
        {
            $redSocial = DB::table('PreguntaFrecuente')->select('titulo')->where('id',$id)->first();

            $data=array();
            $data['estado']    = 0;
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('RedSocial')->where('id', $id)->update($data);

            LogActivity::addToLog('Red Social - Se ha dado de baja la red social '.$redSocial->titulo);
        
            DB::commit();

            return redirect()->route('redes.index')
                            ->with('success','La red social se ha dado de baja correctamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('redes.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }
}
