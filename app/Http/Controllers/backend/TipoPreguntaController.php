<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TipoPregunta;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class TipoPreguntaController extends Controller
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
      $tiposPregunta = DB::table('TipoPregunta')
                        ->paginate(10);
		
      return view('backend.tipoPregunta.index', [
        'tiposPregunta' => $tiposPregunta
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.tipoPregunta.create');
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
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
      ]);

      $data=array();
      $data['descripcion']        = $request->descripcion;     
      
      DB::table('TipoPregunta')->insert($data);
  
      return redirect()->route('tipoPregunta.index')
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
        $redes = DB::table('TipoPregunta')
                              ->where('id', $id)
                              ->first();

        return view('backend.tipoPregunta.show')
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
        $tipoPregunta = DB::table('TipoPregunta')
                              ->where('id', $id)
                              ->first();

        return view('backend.tipoPregunta.edit')
                  ->with('tipoPregunta', $tipoPregunta);
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
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla. ',
      ]);

      $data=array();
      $data['descripcion']       = $request->descripcion; 

      DB::table('TipoPregunta')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('tipoPregunta.index')
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
      
        DB::table('TipoPregunta')
          ->where('id', $id)
          ->delete();

        return redirect()->route('tipoPregunta.index')
          ->with('success','El registro se ha borrado con éxito');
    }
}
