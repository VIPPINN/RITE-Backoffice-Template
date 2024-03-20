<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeHerramientaTipoController extends Controller
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

        $tiposHerramientas = DB::table('HerramientaTipo')->orderBy('orden','asc')->get();

        return view('backend.herramientaTipo.index', ['tiposHerramientas' => $tiposHerramientas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orden = DB::table('HerramientaTipo')->orderBy('orden', 'desc')->first();

        $orden = ($orden->orden) + 1;

        return view('backend.herramientaTipo.create', ['orden' => $orden]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Selecciono el ultimo numero de orden por tipo en caso de que venga vacio*/
        $ultimoOrden = DB::table('HerramientaTipo')
            ->select('orden')
            ->orderBy('orden', 'desc')
            ->first();

        /*Busco en la BD si hay alguna pregunta con el orden que
le estoy dando a la herramienta que quiero agregar*/

        if (DB::table('HerramientaTipo')->where('orden', $request->orden)->exists()) {
            /*Si existe tengo que modificar el orden de todas las preguntas
que tengan orden igual o mayor al que quiero agregar   */

            $this->agregarIncrementarOrden($request->orden);
        }

        if(empty($ultimoOrden)){
            $data['orden'] = 1;
        }else{
            $data['orden'] = $request->orden;
        }

        $data['descripcion'] = $request->descripcion;
        $data['activo'] = 1;
        $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('HerramientaTipo')->insert($data);

        return redirect()->route('herramientaTipo.index')
            ->with('success', 'El tipo de herramienta fue creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $herramienta = DB::table('HerramientaTipo')->where('id', '=', $id)->first();

        return view('backend.herramientaTipo.show', ['tipoHerramienta' => $herramienta]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $herramienta = DB::table('HerramientaTipo')->where('id', '=', $id)->first();
        
        return view('backend.herramientaTipo.edit', ['tipoHerramienta' => $herramienta]);
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

        $herramienta = DB::table('HerramientaTipo')->where('id', $id)->first();
        

        if ( $herramienta->orden != $request->orden) {

           
                $this->incrementarOrden($request->orden,  $herramienta->orden);
            
        }

        $data['descripcion'] = $request->descripcion;
        $data['activo'] =  $request->activo;
        $data['orden']  = $request->orden;

        DB::table('HerramientaTipo')
            ->where('id', $id)
            ->update($data);

        return redirect()->route('herramientaTipo.index')
            ->with('success', 'El Tipo Herramienta fue editado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
        $data['activo'] = 0;

        DB::table('HerramientaTipo')->where('id', $id)->update($data);
        $element = DB::table('HerramientaTipo')->where('id', $id)->first();

        LogActivity::addToLog('Tipo Herramienta - Dió de baja: ' . $element->id);

        return redirect()->route('herramientaTipo.index')
            ->with('success', 'El tipo de herramienta se ha borrado con éxito');
    }

    /**Funcion para incrementar el orden de las herramientas */
    public function incrementarOrden($orden, $ordenOld)
    {
        $herramientas = DB::table('HerramientaTipo')->get();
        
        foreach ($herramientas as $herramienta) {
            //me fijo si el nuevo orden es mayor al anterior
            if ($ordenOld < $orden) {
                //si el orden de la herramienta es mayor al orden anterior de la que modifico
                //y menos al nuevo orden, tengo que decrementar en 1 el orden
                if ($herramienta->orden > $ordenOld && $herramienta->orden <= $orden)
                    $herramienta->orden = ($herramienta->orden) - 1;
                $data['orden'] = $herramienta->orden;

                DB::table('HerramientaTipo')
                    ->where('id', $herramienta->id)
                    ->update($data);
                //si el orden de la herramienta es mayor ' igual al nuevo orden
                //lo incremento en  1
            } else if ($herramienta->orden >= $orden) {
               
                $herramienta->orden = ($herramienta->orden) + 1;

                $data['orden'] = $herramienta->orden;

                DB::table('HerramientaTipo')
                    ->where('id', $herramienta->id)
                    ->update($data);
            }
        }
    }

    /**Funcion para decrementar el orden de las herramientas */
    public function agregarIncrementarOrden($orden)
    {
        $herramientas = DB::table('HerramientaTipo')->get();

        foreach ($herramientas as  $herramienta) {
            if ($herramienta->orden >= $orden) {
                $herramienta->orden = ($herramienta->orden) + 1;

                $data['orden'] = $herramienta->orden;

                DB::table('HerramientaTipo')
                    ->where('id', $herramienta->id)
                    ->update($data);
            }
        }
    }
}
