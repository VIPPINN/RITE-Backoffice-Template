<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;

class HomeRiteNumerosController extends Controller
{
    public function index()
    {
        $riteNumeros = DB::table('riteNumero')->where('fechaBaja',NULL)->get();
        return view('backend.riteNumeros.index', ['riteNumeros' => $riteNumeros]);
    }

    public function create()
    {
        return view('backend.riteNumeros.create');
    }

    private function desabilitarCard($id)
    {
        $data['estado'] = 0;

        DB::table('riteNumero')->where('id', $id)->update($data);
    }


    private function buscarActivos()
    {
        $riteNumeros = DB::table('riteNumero')->get();

        foreach ($riteNumeros as $key => $registro) {
            if ($registro->estado == 1) {
                $this->desabilitarCard($registro->id);
            }
        }
    }

    public function store(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {

        DB::beginTransaction();
        try {
            $data = array();
            if ($request->imagepc == null) {
                $request->validate(['imagepc' => 'required'], ['imagepc.required' => '(*) Debe cargar una imagen para el carrusel. ']);
            } else {
                $data['imagen'] = $serviceNombre->GenerarNombre($request->imagepc, 'riteNumeros', 'riteNumero', 'imagen');
            }

            $data['titulo']         = $request->title;
            $data['texto']         = $request->texto;


            if ($request->status == 'on') {
                $data['estado'] = 1;
                //llamo a la funcion para que a todos los registros les ponga 0 si estan activos para poder activar el que se agrega
                $this->buscarActivos();
            } else {
                $data['estado'] = 0;
            }
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');


            DB::table('riteNumero')->insert($data);

            DB::commit();

            return redirect()->route('riteNumeros.index')
                ->with('success', 'El slider fue creado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('riteNumeros.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    private function buscarActivo($id = 0)
    {

        return (DB::table('riteNumero')->where('estado', 1)->where('id', '!=', $id)->get());
    }

    public function edit($id)
    {
        $riteNumero = DB::table('riteNumero')->where('id', $id)->first();

        return view('backend.riteNumeros.edit', ['riteNumero' => $riteNumero]);
    }

    public function update(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            $data = array();
            if ($request->imagepc != null) {
                $data['imagen'] = $serviceNombre->GenerarNombre($request->imagepc, 'riteNumeros', 'riteNumero', 'imagen');
            }


            $data['titulo']         = $request->title;
            $data['texto']         = $request->texto;

            if ($request->status) {
                if ($request->status == 'on') {
                    $data['estado'] = 1;
                    //llamo a la funcion para que a todos los registros les ponga 0 si estan activos para poder activar el que se edita
                    $this->buscarActivos();
                }
            }



            DB::table('riteNumero')->where('id', $id)->update($data);

            DB::commit();


            return redirect()->route('riteNumeros.index')
                ->with('success', 'El slider fue editado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('riteNumeros.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }



    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
            $data['estado'] = 0;
            DB::table('riteNumero')->where('id', $id)->update($data);

            //hago un if para validar que, si se desactiva este...haya al menos 1 activo, sino no me deja borrarlo
            if ($this->buscarActivo()->isEmpty()) {
                DB::rollback();
                return redirect()->route('riteNumeros.index')->withErrors(['error' => 'No se puede borrar ya que no quedaría ninguno activo']);
                
            } else {
                DB::commit();
            }


            return redirect()->route('riteNumeros.index')
                ->with('success', 'El slider fue borrado satisfactoriamente.');
        } catch (Throwable $e) {
            DB::rollback();
            return redirect()->route('riteNumeros.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }
}
