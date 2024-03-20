<?php

namespace App\Http\Controllers\backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RegistrarseController extends Controller
{
    public function index()
    {
        $registrarse = DB::table('Registrarse')
        ->where('fechaBaja',NULL)
        ->get();

        return view('backend.registrarse.index', ['registrarse' => $registrarse]);
    }

    public function create()
    {
        return view('backend.registrarse.create');
    }

    private function desabilitarRegistrarse($id)
    {
        $data['estado'] = 0;

        DB::table('Registrarse')->where('id', $id)->update($data);
    }

    private function buscarActivos()
    {
        $registrarse = DB::table('Registrarse')->get();

        foreach ($registrarse as $key => $registro) {
            if ($registro->estado == 1) {
                $this->desabilitarRegistrarse($registro->id);
            }
        }
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $data = array();


            $data['titulo']         = $request->title;
            $data['texto']         = $request->texto;


            if ($request->status == 'on') {
                $data['estado'] = 1;
                $this->buscarActivos();
            } else {
                $data['estado'] = 0;
            }
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');


            DB::table('Registrarse')->insert($data);

            DB::commit();

            return redirect()->route('registrarse.index')
                ->with('success', 'El slider fue creado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('registrarse.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    public function edit($id)
    {
        $registro = DB::table('Registrarse')
            ->where('id', $id)
            ->first();

        return view('backend.registrarse.edit', ['registro' => $registro]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            //valido el estado
            if ($request->status) {
                if ($request->status == 'on') {
                    $data['estado'] = 1;
                    $this->buscarActivos();
                }
            }

            $data['titulo']         = $request->title;
            $data['texto']         = $request->texto;

            DB::table('Registrarse')->where('id', $id)->update($data);

            DB::commit();

            return redirect()->route('registrarse.index')
                ->with('success', 'El slider fue editado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('registrarse.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    public function destroy($id)
    {
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
        DB::table('Registrarse')->where('id',$id)->update($data);

        return redirect()->route('registrarse.index')
        ->with('success', 'El card registrarse fue borrado satisfactoriamente.');
    }
}
