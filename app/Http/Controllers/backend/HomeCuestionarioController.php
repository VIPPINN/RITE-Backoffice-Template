<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\HomeCuestionario;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeCuestionarioController extends Controller
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
      $cuestionarios = DB::table('Cuestionario')
                        ->paginate(10);
		
      return view('backend.cuestionarios.index', [
        'cuestionarios' => $cuestionarios
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.cuestionarios.create');
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
      $data['estadoTyC']          =0;
      if($request->estado==null){
        $data['estadoAoI']            = false;
      }else{
        $data['estadoAoI']            = true;
      }
      
      DB::table('Cuestionario')->insert($data);

    ///TRAER TOODOS LOS USUARIOS Y GENERAN UN REFISTRO POR CADA UNO Y CADA CUESTIONARIO

    $usuarios=DB::table('Usuarios')->get();
   
    $cuestionarios=DB::table('Cuestionario')->get();

    foreach($cuestionarios as $index => $cuestionario){
      foreach($usuarios as $index => $usuario){
          $datatyc['idUsuario']        = $usuario->id;   
          $datatyc['idCuestionario']   = $cuestionario->id;
          $datatyc['estadoTyC']        = 0;   
          $datatyc['fechaAlta']        =DB::raw('CURRENT_TIMESTAMP');

          DB::table('UsuarioTyC')->insert($datatyc);

      }

    }
  
      $data1=array();
      $data1['idCuestionario']     =$idCuestionario;   
      $data1['fechaAlta']          =DB::raw('CURRENT_TIMESTAMP');    
    
      
      DB::table('CuestionarioVersion')->insert($data1);
      return redirect()->route('cuestionarios.index')
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

    public function versiones($id)
    {
      
        DB::table('Cuestionario')
          ->where('id', $id)
          ->delete();

        return redirect()->route('cuestionarioVersion.index')
          ->with('success','El registro se ha borrado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuestionario = DB::table('Cuestionario')
                              ->where('id', $id)
                              ->first();

        return view('backend.cuestionarios.edit')
                  ->with('cuestionario', $cuestionario);
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
      if($request->estado==null){
        $data['estadoAoI']            = 0;
      }           
      if($request->estado == "on"){             
        $data['estadoAoI']            = 1;
      }        

      DB::table('Cuestionario')
          ->where('id', $id)
          ->update($data);

      return redirect()->route('cuestionarios.index')
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
      
        DB::table('Cuestionario')
          ->where('id', $id)
          ->delete();

        return redirect()->route('cuestionarios.index')
          ->with('success','El registro se ha borrado con éxito');
    }

   
}
