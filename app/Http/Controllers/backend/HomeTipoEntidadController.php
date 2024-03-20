<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TipoEntidad;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeTipoEntidadController extends Controller
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
      $tiposEntidad = DB::table('TipoEntidad')
                        ->Join('GrupoEntidad', 'TipoEntidad.idGrupoEntidad', '=', 'GrupoEntidad.id')
                        ->select(
                          'GrupoEntidad.id AS idGrupoEntidad',
                          'GrupoEntidad.descripcion AS descripcionGrupoEntidad',
                          'TipoEntidad.id AS id',
                          'TipoEntidad.orden AS orden',
                          'TipoEntidad.descripcion AS descripcion',
                      )
                        ->paginate(10);
		
      return view('backend.tipoEntidad.index', [
        'tiposEntidad' => $tiposEntidad
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         $GruposEntidad = DB::table('GrupoEntidad')->get();

        return view('backend.tipoEntidad.create', ['GruposEntidad' => $GruposEntidad]);
    }

    /**Funcion para aumentar el orden de las preguntas */
    public function incrementarOrden($orden, $idGrupoEntidad)
    {
        $tiposEntidad = DB::table('TipoEntidad')->where('idGrupoEntidad', $idGrupoEntidad)->get();

        foreach ($tiposEntidad as $tipoEntidad) {
            if ($tipoEntidad->orden >= $orden) {
                $tipoEntidad->orden = ($tipoEntidad->orden) + 1;

                $data['orden'] = $tipoEntidad->orden;

                DB::table('TipoEntidad')
                    ->where('id', $tipoEntidad->id)
                    ->update($data);
            }
        }
    }

    /**Funcion para decrementar el orden de las preguntas */
    public function decrementarOrden($orden, $ordenOld, $idGrupoEntidad)
    {
        $tiposEntidad = DB::table('TipoEntidad')->where('idGrupoEntidad', $idGrupoEntidad)->get();

        foreach ($tiposEntidad as $tipoEntidad) {
            if ($tipoEntidad->orden >= $orden && $tipoEntidad->orden < $ordenOld) {
                $tipoEntidad->orden = ($tipoEntidad->orden) + 1;

                $data['orden'] = $tipoEntidad->orden;

                DB::table('TipoEntidad')
                    ->where('id', $tipoEntidad->id)
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
        'idGrupoEntidad' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
        'orden.required' => '(*) El orden es requerido. Debe ingresarlo.',
        'idGrupoEntidad.required' => '(*) El grupo es requerido. Debe seleccionarlo.',
      ]);

      $data=array();

       /*Busco en la BD si hay alguna pregunta con el orden que
        le estoy dandoa la pregunta que quiero agregar*/

        if (DB::table('TipoEntidad')->where('orden', $request->orden)->where('idGrupoEntidad', $request->idGrupoEntidad)->exists()) {
          /*Si existe tengo que modificar el orden de todas las preguntas
          que tengan orden igual o mayor al que quiero agregar   */
          $this->incrementarOrden($request->orden, $request->idGrupoEntidad);
      }

      $data['descripcion']        = $request->descripcion;
      $data['orden']        = $request->orden;     
      $data['idGrupoEntidad']        = $request->idGrupoEntidad;      
      
      DB::table('TipoEntidad')->insert($data);
  
      return redirect()->route('tipoEntidad.index')
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
        $redes = DB::table('TipoEntidad')
                              ->where('id', $id)
                              ->first();

        return view('backend.tipoEntidad.show')
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
        $tipoEntidad = DB::table('TipoEntidad')
                              ->where('id', $id)
                              ->first();

        $gruposEntidad = DB::table('GrupoEntidad')->get();

        return view('backend.tipoEntidad.edit')
                  ->with(['tipoEntidad' => $tipoEntidad, 'gruposEntidad' => $gruposEntidad]);
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
        'idGrupoEntidad' => 'required',
      ],
      [
        'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla. ',
        'orden.required' => '(*) El orden requerido. Debe ingresarlo. ',
        'idGrupoEntidad.required' => '(*) El Grupo requerido. Debe seleccionarlo. ',
      ]);

      $tipoEntidad = DB::table('TipoEntidad')->where('id', $id)->first();
        if ($tipoEntidad->orden != $request->orden) {

            if ($tipoEntidad->orden > $request->orden) {
                $this->decrementarOrden($request->orden, $tipoEntidad->orden, $request->idGrupoEntidad);
            } else {
                $this->incrementarOrden($request->orden, $request->idGrupoEntidad);
            }
        }

      $data=array();
      $data['descripcion']       = $request->descripcion; 
      $data['orden']       = $request->orden; 
      $data['idGrupoEntidad']       = $request->idGrupoEntidad; 

      DB::table('TipoEntidad')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('tipoEntidad.index')
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
      
        DB::table('TipoEntidad')
          ->where('id', $id)
          ->delete();

        return redirect()->route('tipoEntidad.index')
          ->with('success','El registro se ha borrado con éxito');
    }
}
