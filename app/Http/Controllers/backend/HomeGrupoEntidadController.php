<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\GrupoEntidad;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeGrupoEntidadController extends Controller
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
      $gruposEntidad = DB::table('GrupoEntidad')
                        ->paginate(10);
		
      return view('backend.gruposEntidad.index', [
        'gruposEntidad' => $gruposEntidad
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.gruposEntidad.create');
    }

    /**Funcion para aumentar el orden de las preguntas */
    public function incrementarOrden($orden)
    {
        $GruposEntidad = DB::table('GrupoEntidad')->get();

        foreach ($GruposEntidad as $GrupoEntidad) {
            if ($GrupoEntidad->orden >= $orden) {
                $GrupoEntidad->orden = ($GrupoEntidad->orden) + 1;

                $data['orden'] = $GrupoEntidad->orden;

                DB::table('GrupoEntidad')
                    ->where('id', $GrupoEntidad->id)
                    ->update($data);
            }
        }
    }

    /**Funcion para decrementar el orden de las preguntas */
    public function decrementarOrden($orden, $ordenOld)
    {
        $GruposEntidad = DB::table('GrupoEntidad')->get();

        foreach ($GruposEntidad as $GrupoEntidad) {
            if ($GrupoEntidad->orden >= $orden && $GrupoEntidad->orden < $ordenOld) {
                $GrupoEntidad->orden = ($GrupoEntidad->orden) + 1;

                $data['orden'] = $GrupoEntidad->orden;

                DB::table('GrupoEntidad')
                    ->where('id', $GrupoEntidad->id)
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

        if (DB::table('GrupoEntidad')->where('orden', $request->orden) ->exists()) {
          /*Si existe tengo que modificar el orden de todas las preguntas
          que tengan orden igual o mayor al que quiero agregar   */
          $this->incrementarOrden($request->orden);
      }

      $data['descripcion']        = $request->descripcion;
      $data['orden']        = $request->orden;      
      
      DB::table('GrupoEntidad')->insert($data);
  
      return redirect()->route('gruposEntidad.index')
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
        $redes = DB::table('Cuestionario')
                              ->where('id', $id)
                              ->first();

        return view('backend.cuestionarios.show')
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
        $GrupoEntidad = DB::table('GrupoEntidad')
                              ->where('id', $id)
                              ->first();

        return view('backend.gruposEntidad.edit')
                  ->with('GrupoEntidad', $GrupoEntidad);
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

      $GrupoEntidad = DB::table('GrupoEntidad')->where('id', $id)->first();
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

      DB::table('GrupoEntidad')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('gruposEntidad.index')
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
      
        DB::table('GrupoEntidad')
          ->where('id', $id)
          ->delete();

        return redirect()->route('gruposEntidad.index')
          ->with('success','El registro se ha borrado con éxito');
    }
}
