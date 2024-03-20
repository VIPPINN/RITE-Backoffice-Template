<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoriaEntidad;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeCategoriaEntidadController extends Controller
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
      $categoriasEntidad = DB::table('CategoriaEntidad')
                        ->paginate(10);
		
      return view('backend.categoriasEntidad.index', [
        'categoriasEntidad' => $categoriasEntidad
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.categoriasEntidad.create');
    }

    /**Funcion para aumentar el orden de las preguntas */
    public function incrementarOrden($orden)
    {
        $CategoriasEntidad = DB::table('CategoriaEntidad')->get();

        foreach ($CategoriasEntidad as $CategoriaEntidad) {
            if ($CategoriaEntidad->orden >= $orden) {
                $CategoriaEntidad->orden = ($CategoriaEntidad->orden) + 1;

                $data['orden'] = $CategoriaEntidad->orden;

                DB::table('CategoriaEntidad')
                    ->where('id', $CategoriaEntidad->id)
                    ->update($data);
            }
        }
    }

    /**Funcion para decrementar el orden de las preguntas */
    public function decrementarOrden($orden, $ordenOld)
    {
        $CategoriasEntidad = DB::table('CategoriaEntidad')->get();

        foreach ($CategoriasEntidad as $CategoriaEntidad) {
            if ($CategoriaEntidad->orden >= $orden && $CategoriaEntidad->orden < $ordenOld) {
                $CategoriaEntidad->orden = ($CategoriaEntidad->orden) + 1;

                $data['orden'] = $CategoriaEntidad->orden;

                DB::table('CategoriaEntidad')
                    ->where('id', $CategoriaEntidad->id)
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

        if (DB::table('CategoriaEntidad')->where('orden', $request->orden)->exists()) {
          /*Si existe tengo que modificar el orden de todas las preguntas
          que tengan orden igual o mayor al que quiero agregar   */
          $this->incrementarOrden($request->orden);
      }

      $data['descripcion']        = $request->descripcion;
      $data['orden']        = $request->orden;      
      
      DB::table('CategoriaEntidad')->insert($data);
  
      return redirect()->route('categoriasEntidad.index')
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
        $redes = DB::table('CategoriaEntidad')
                              ->where('id', $id)
                              ->first();

        return view('backend.categoriasEntidad.show')
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
        $CategoriaEntidad = DB::table('CategoriaEntidad')
                              ->where('id', $id)
                              ->first();

        return view('backend.categoriasEntidad.edit')
                  ->with('CategoriaEntidad', $CategoriaEntidad);
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

      $GrupoEntidad = DB::table('CategoriaEntidad')->where('id', $id)->first();
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

      DB::table('CategoriaEntidad')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('categoriasEntidad.index')
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
      
        DB::table('CategoriaEntidad')
          ->where('id', $id)
          ->delete();

        return redirect()->route('categoriasEntidad.index')
          ->with('success','El registro se ha borrado con éxito');
    }
}
