<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CuestionarioVersion;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeCuestionarioVersionController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cuestionariosVersion = DB::table('CuestionarioVersion')
                        ->Join('Cuestionario', 'CuestionarioVersion.idCuestionario', '=', 'Cuestionario.id')
                        ->select(
                          'Cuestionario.id AS idCuestionario',
                          'Cuestionario.descripcion AS descripcionCuestionario',
                          'CuestionarioVersion.id AS id',
                          'CuestionarioVersion.descripcion AS descripcion',
                          'CuestionarioVersion.fechaAlta AS fechaAlta',
                          'CuestionarioVersion.fechaBaja AS fechaBaja',
                      )
                        ->paginate(10);
		
      return view('backend.cuestionarioVersion.index', [
        'cuestionariosVersion' => $cuestionariosVersion
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         $Cuestionarios = DB::table('Cuestionario')->get();

        return view('backend.cuestionarioVersion.create', ['Cuestionarios' => $Cuestionarios]);
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
        'descripcion' => 'required',
        'idCuestionario' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
        'idCuestionario.required' => '(*) El cuestionario es requerido. Debe seleccionarlo.',
      ]);

      $data=array();


      $data['descripcion']        = $request->descripcion;
      $data['fechaAlta'] = date("Y-m-d") ;     
      $data['idCuestionario']        = $request->idCuestionario;      
      
      DB::table('CuestionarioVersion')->insert($data);
  
      return redirect()->route('cuestionarioVersion.index')
                      ->with('success','El registro fue creado satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view('sliders.show', compact('HomeRedes'));
        $CuestionariosVersion = DB::table('CuestionarioVersion')
                              ->where('id', $id)
                              ->first();

        return view('backend.cuestionarioVersion.show')
                  ->with('CuestionariosVersion', $CuestionariosVersion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $CuestionarioVersion = DB::table('CuestionarioVersion')
                              ->where('id', $id)
                              ->first();

        $Cuestionarios = DB::table('Cuestionario')->get();

        return view('backend.cuestionarioVersion.edit')
                  ->with(['CuestionarioVersion' => $CuestionarioVersion, 'Cuestionarios' => $Cuestionarios]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
      $request->validate([
        'descripcion' => 'required',
        'idCuestionario' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
        'idCuestionario.required' => '(*) El cuestionario es requerido. Debe seleccionarlo.',
      ]);


      $data=array();
      $data['descripcion']       = $request->descripcion; 
      $data['idCuestionario']       = $request->idCuestionario; 

      DB::table('CuestionarioVersion')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('cuestionarioVersion.index')
                      ->with('success','El registro se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $data=array();
      $data['fechaBaja'] = date("Y-m-d") ;   

      DB::table('CuestionarioVersion')
          ->where('id', $id)
          ->update($data);
      
        /*DB::table('TipoEntidad')
          ->where('id', $id)
          ->delete(); */

        return redirect()->route('cuestionarioVersion.index')
          ->with('success','El registro se ha borrado con éxito');
    }
}
