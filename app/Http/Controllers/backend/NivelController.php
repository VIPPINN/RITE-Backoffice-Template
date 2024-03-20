<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Nivel;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class NivelController extends Controller
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
      $niveles = DB::table('Nivel')
                        ->paginate(10);
		
      return view('backend.nivel.index', [
        'niveles' => $niveles
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.nivel.create');
    }

    /**Funcion para aumentar el orden de las preguntas */
    public function incrementarOrden($orden)
    {
        $niveles = DB::table('Nivel')->get();

        foreach ($niveles as $nivel) {
            if ($nivel->orden >= $orden) {
                $nivel->orden = ($nivel->orden) + 1;

                $data['orden'] = $nivel->orden;

                DB::table('Nivel')
                    ->where('id', $nivel->id)
                    ->update($data);
            }
        }
    }

    /**Funcion para decrementar el orden de las preguntas */
    public function decrementarOrden($orden, $ordenOld)
    {
        $niveles = DB::table('Nivel')->get();

        foreach ($niveles as $nivel) {
            if ($nivel->orden >= $orden && $nivel->orden < $ordenOld) {
                $nivel->orden = ($nivel->orden) + 1;

                $data['orden'] = $nivel->orden;

                DB::table('Nivel')
                    ->where('id', $nivel->id)
                    ->update($data);
            }
        }
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
        'orden' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
        'orden.required' => '(*) El orden es requerido. Debe ingresarlo.',
      ]);

      $data=array();

       /*Busco en la BD si hay alguna pregunta con el orden que
        le estoy dandoa la pregunta que quiero agregar*/

        if (DB::table('Nivel')->where('orden', $request->orden)->exists()) {
          /*Si existe tengo que modificar el orden de todas las preguntas
          que tengan orden igual o mayor al que quiero agregar   */
          $this->incrementarOrden($request->orden);
      }

      $data['descripcion']        = $request->descripcion;
      $data['orden']        = $request->orden;      
      
      DB::table('Nivel')->insert($data);
  
      return redirect()->route('nivel.index')
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
        $niveles = DB::table('Nivel')
                              ->where('id', $id)
                              ->first();

        return view('backend.nivel.show')
                  ->with('niveles', $niveles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nivel = DB::table('nivel') ->where('id', $id) ->first();

        return view('backend.nivel.edit')->with('nivel', $nivel);
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
        'orden' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla. ',
        'orden.required' => '(*) El orden requerido. Debe ingresarlo. ',
      ]);

      $GrupoEntidad = DB::table('Nivel')->where('id', $id)->first();
        if ($GrupoEntidad->orden != $request->orden) {
            if ($GrupoEntidad->orden > $request->orden) {
                $this->decrementarOrden($request->orden, $GrupoEntidad->orden);
            } else {
                $this->incrementarOrden($request->orden);
            }
        }

      $data=array();
      $data['descripcion']       = $request->descripcion; 
      $data['orden']       = $request->orden; 

      DB::table('Nivel')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('nivel.index')
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
      
        DB::table('Nivel')
          ->where('id', $id)
          ->delete();

        return redirect()->route('nivel.index')
          ->with('success','El registro se ha borrado con éxito');
    }
}
