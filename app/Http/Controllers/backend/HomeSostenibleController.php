<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;



class HomeSostenibleController extends Controller
{
    public function index()
    {
        $sostenibles = DB::table('Sostenible')->where('fechaBaja', NULL)->get();

        return view('backend.sostenible.index', ['sostenibles' => $sostenibles]);
    }

    public function crear()
    {

        return view('backend.sostenible.create');
    }

    public function guardar(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = array();

            $data['titulo']         = $request->title;
            $data['texto']         = $request->texto;


            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');


            DB::table('Sostenible')->insert($data);

            DB::commit();

            $sostenibles = DB::table('Sostenible')->where('fechaBaja', NULL)->get();

            return view('backend.sostenible.index', ['sostenibles' => $sostenibles]);
        } catch (Throwable $e) {
            DB::rollback();
            return view('backend.sostenible.index');
        }
    }

    public function editar($id)
    {
        $sostenible = DB::table('Sostenible')->where('id', $id)->first();

        return view('backend.sostenible.edit', ['sostenible' => $sostenible]);
    }

    public function actualizar(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $data = array();

            $data['titulo']         = $request->title;
            $data['texto']         = $request->texto;


            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }
           


            DB::table('Sostenible')->where('id', $id)->update($data);

            DB::commit();

            $sostenibles = DB::table('Sostenible')->where('fechaBaja', NULL)->get();

            return view('backend.sostenible.index', ['sostenibles' => $sostenibles]);
        } catch (Throwable $e) {
            DB::rollback();
            return view('backend.sostenible.index');
        }
    }

    public function destroySostenible($id)
    {
        DB::beginTransaction();
        try {
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('Sostenible')->where('id', $id)->update($data);

            DB::commit();

            $sostenibles = DB::table('Sostenible')->where('fechaBaja', NULL)->get();

            return view('backend.sostenible.index', ['sostenibles' => $sostenibles]);
        } catch (Throwable $e) {
            DB::rollback();
            return view('backend.sostenible.index');
        }
    }

    public function indexSostenibleCuestionarios($id)
    {
        $cuestionarios = DB::table('SostenibleCuestionario')->where('idSostenible', $id)->get();

        return view('backend.sostenible.indexCuestionarios',['cuestionarios' => $cuestionarios , 'idSostenible' => $id]);
    }

    public function crearSostenibleCuestionarios($id){
        
        return view('backend.sostenible.crearCuestionario',['idSostenible' => $id]);

    }

    public function storeSostenibleCuestionarios(Request $request,$id){
        
        $data['titulo'] = $request->title;
        $data['texto'] = $request->texto;
        $data['idSostenible'] = $id;
        $data['color'] = "#".$request->color;

        DB::table('SostenibleCuestionario')->insert($data);

        $cuestionarios = DB::table('SostenibleCuestionario')->where('idSostenible', $id)->get();

        return view('backend.sostenible.indexCuestionarios',['cuestionarios' => $cuestionarios , 'idSostenible' => $id]);
    }

    public function editarSostenibleCuestionarios($id){
        $cuestionario = DB::table('SostenibleCuestionario')->where('id',$id)->first();

        return view('backend.sostenible.editarCuestionarios',['cuestionario' => $cuestionario]);

    }


    public function updateSostenibleCuestionarios(Request $request,$id){

        $buscarCuestionario = DB::table('SostenibleCuestionario')->where('id',$id)->first();
        $idSostenible = $buscarCuestionario->idSostenible;
        $data['titulo'] = $request->title;
        $data['texto'] = $request->texto;
        $data['color'] = $request->color;

        DB::table('SostenibleCuestionario')->where('id',$id)->update($data);

        $cuestionarios = DB::table('SostenibleCuestionario')->where('idSostenible', $idSostenible)->get();

        return view('backend.sostenible.indexCuestionarios',['cuestionarios' => $cuestionarios , 'idSostenible' => $idSostenible]);
    }
}
