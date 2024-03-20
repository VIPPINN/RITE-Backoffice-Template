<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;

use Illuminate\Http\Request;

class CitasController extends Controller
{
    public function index()
    {
        $citas = DB::table('Citas')->where('fechaBaja','=',NULL)->get();

        return view('backend.citas.index', ['citas' => $citas]);
    }

    public function create()
    {
        return view('backend.citas.create');
    }

    public function store(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {

        DB::beginTransaction();
        try {
            $data = array();
            if ($request->imagepc == null) {
                $request->validate(['imagepc' => 'required'], ['imagepc.required' => '(*) Debe cargar una imagen para el carrusel. ']);
            } else {
                $data['icono'] = $serviceNombre->GenerarNombre($request->imagepc, 'CitasIconos', 'Citas', 'icono');
            }


            $data['texto']         = $request->title;
            $data['usuarioCita']         = $request->usuario;

            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');


            DB::table('Citas')->insert($data);

            DB::commit();

            return redirect()->route('citas.index')
                ->with('success', 'El slider fue creado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('citas.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    public function edit($id)
    {
        $cita = DB::table('Citas')->where('id', $id)->first();

        return view('backend.citas.edit', ['cita' => $cita]);
    }

    public function update(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            $data = array();
            if ($request->imagepc != null) {
                $data['icono'] = $serviceNombre->GenerarNombre($request->imagepc, 'CitasIconos', 'Citas', 'icono');
            }


            $data['texto']         = $request->title;
            $data['usuarioCita']         = $request->usuario;

            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }



            DB::table('Citas')->where('id',$id)->update($data);

            DB::commit();

            return redirect()->route('citas.index')
                ->with('success', 'El slider fue editado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('citas.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    public function destroy($id)
    {
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
        DB::table('Citas')->where('id',$id)->update($data);

        return redirect()->route('citas.index')
        ->with('success', 'El slider fue borrado satisfactoriamente.');
    }
}
