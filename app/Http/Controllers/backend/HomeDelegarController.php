<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeDelegarController extends Controller
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

        $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
        $idGrupoSimulacion = $grupoSimulacion->id;

        $usuarioSimulacion = DB::table('GrupoUsuario')->where('descripcion','LIKE','%Simulacion%')->first();
        $idUsuarioSimulacion = $usuarioSimulacion->id;
        $relaciones = DB::table('Usuario as u1')
            ->join('UsuarioDelegado as ud', 'ud.idUsuarioDelegado', '=', 'u1.id')
            ->select(
                'u1.Nombre as nombre',
                'u1.apellido as apellido',
                'ud.idUsuarioQueDelega as idUsuarioQueDelega',
                'ud.fechaAlta as fechaAlta',
                'ud.fechaBaja as fechaBaja',
                'ud.id as id'
            )
            ->where('ud.fechaBaja', NULL)
            ->where('u1.idGrupoUsuario', '!=', $idGrupoSimulacion)
            ->where('u1.idGrupoUsuario','!=', $idUsuarioSimulacion)
            ->get();


        foreach ($relaciones as $index => $relacion) {

            $empresa = DB::table('Usuario')->select('razonSocial')->where('id', '=', $relacion->idUsuarioQueDelega)->first();
            $relacion->razonSocial = $empresa->razonSocial;
        }


        return view('backend.delegar.index', ['relaciones' => $relaciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Busco usuarios que ya tengan alguna empresa relacionada
        //$usuariosConRelacion = DB::table('UsuarioDelegado')->select('idUsuarioDelegado')->where('fechaBaja','=',NULL)->get();
        //Busco empresas que ya tengan algun usuario relacionado
        //$empresaConRelacion = DB::table('UsuarioDelegado')->select('idUsuarioQueDelega')->where('fechaBaja','=',NULL)->get();

        //Busco usuarios dados de baja
        $usuariosBaja = DB::table('Usuario')->where('Usuario.fechaBaja', '!=', NULL)->where('idTipoPersona', '=', 1)->get();

        //Busco empresas dados de baja
        $empresasBaja = DB::table('Usuario')->where('Usuario.fechaBaja', '!=', NULL)->where('idTipoPersona', '=', 2)->get();

        $usuarioSimulacion = DB::table('GrupoUsuario')->where('descripcion','LIKE','%Simulacion%')->first();
        
        $empresaSimulacion = DB::table('GrupoUsuario')->where('descripcion','LIKE','%Prueba%')->first();

        //los paso a array para poder usarlos en el whereNotIn
        $usuariosCR = [];
        $empresaCR = [];
        $usuariosB = [];
        $empresasB = [];
        /*  foreach ($usuariosConRelacion as $key => $value) {
            $usuariosCR[] = $value->idUsuarioDelegado;

        }

        foreach ($empresaConRelacion as $key => $value) {
            $empresaCR[] = $value->idUsuarioQueDelega;

        } */

        foreach ($usuariosBaja as $key => $value) {
            $usuariosB[] = $value->id;
        }

        foreach ($empresasBaja as $key => $value) {
            $empresasB[] = $value->id;
        }

        //traigo usuarios y empresas que aun no tengan una relacion
        $usuarios = DB::table('Usuario')
            ->where('idTipoPersona', '=', 1)
            ->where('idGrupoUsuario','!=',$usuarioSimulacion->id)
            ->whereNotIn('Usuario.id', $usuariosB)
            ->get();
        $empresas = DB::table('Usuario')
            ->where('idTipoPersona', '=', 2)
            ->where('idGrupoUsuario','!=',$empresaSimulacion->id)
            ->whereNotIn('Usuario.id', $empresasB)
            ->get();



        return view('backend.delegar.create', [
            'usuarios' => $usuarios,
            'empresas' => $empresas
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data['idUsuarioDelegado'] = $request->usuario;
        $data['idUsuarioQueDelega'] = $request->empresa;
        $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

        
        DB::table('UsuarioDelegado')->insert($data);
        $usuario = DB::table('Usuario')->where('id', $request->usuario)->first();
        $empresa = DB::table('Usuario')->where('id', $request->empresa)->first();
        // Delegacion Creacion
        LogActivity::addToLog('Delegación - Creacion: Usuario: ' . $usuario->nombre . ' , ' . $usuario->apellido . ' - Entidad : '.  $empresa->razonSocial);

        return redirect()->route('delegar.index')
            ->with('success', 'La relacion fue creada satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeRedes  $HomeRedes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

        DB::table('UsuarioDelegado')->where('id', $id)->update($data);
        $element1 = DB::table('UsuarioDelegado')
        ->join('Usuario','Usuario.id','UsuarioDelegado.idUsuarioDelegado')
        ->where('UsuarioDelegado.id', $id)->first();

        $element2 = DB::table('UsuarioDelegado')
        ->join('Usuario','Usuario.id','UsuarioDelegado.idUsuarioQueDelega')
        ->where('UsuarioDelegado.id', $id)->first();

        LogActivity::addToLog('Delegación - Dió de baja: ' . $element1->nombre . ' , '. $element1->apellido . ' | ' . $element2->razonSocial);

        return redirect()->route('delegar.index')
            ->with('success', 'La relacion se ha borrado con éxito');
    }
}
