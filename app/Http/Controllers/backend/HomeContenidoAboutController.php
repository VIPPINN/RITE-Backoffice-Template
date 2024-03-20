<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\ArchivoNombreCargadoService;

class HomeContenidoAboutController extends Controller
{
    public function index()
    {

        $contenidos = DB::table('ContenidoAbout')
            ->where('fechaBaja', NULL)
            ->where('estado', 1)->get();

        return view('backend.contenidoAbout.index', ['contenidos' => $contenidos]);
    }

    public function crear()
    {
        return view('backend.contenidoAbout.crear');
    }

    public function guardar(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        $pdfFile = $request->file('imagepc');

        // Obtiene el nombre original del archivo
        $pdfFileName = $pdfFile->getClientOriginalName();

        
        DB::beginTransaction();
        try {
            $data = array();
            if ($request->imagepc == null) {
                $request->validate(['imagepc' => 'required'], ['imagepc.required' => '(*) Debe cargar un documento para descargar. ']);
            } else {
                $data['documento'] = $serviceNombre->GenerarNombreSinModificar($request->imagepc,$pdfFileName, 'ContenidoAbout', 'ContenidoAbout', 'documento');
            }


            $data['titulo']         = $request->title;

            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');


            DB::table('ContenidoAbout')->insert($data);

            DB::commit();

            $contenidos = DB::table('ContenidoAbout')
                ->where('fechaBaja', NULL)
                ->where('estado', 1)->get();

            return view('backend.contenidoAbout.index', ['contenidos' => $contenidos]);
        } catch (Throwable $e) {
            DB::rollback();


            $contenidos = DB::table('ContenidoAbout')
                ->where('fechaBaja', NULL)
                ->where('estado', 1)->get();

            return view('backend.contenidoAbout.index', ['contenidos' => $contenidos]);
        }
    }

    public function editar($id)
    {
        $contenido = DB::table('ContenidoAbout')->where('id', $id)->where('estado', 1)->first();

        return view('backend.contenidoAbout.editar', ['contenido' => $contenido]);
    }

    public function actualizar(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        $pdfFile = $request->file('imagepc');

        // Obtiene el nombre original del archivo
        $pdfFileName = $pdfFile->getClientOriginalName();
        DB::beginTransaction();
        try {
            $data = array();
            if ($request->imagepc != null) {
                $data['documento'] = $serviceNombre->GenerarNombreSinModificar($request->imagepc,$pdfFileName, 'ContenidoAbout', 'ContenidoAbout', 'documento');
            }


            $data['titulo']  = $request->title;


            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }




            DB::table('ContenidoAbout')->where('id', $id)->update($data);

            DB::commit();

            $contenidos = DB::table('ContenidoAbout')
                ->where('fechaBaja', NULL)
                ->where('estado', 1)->get();

            return view('backend.contenidoAbout.index', ['contenidos' => $contenidos]);
        } catch (Throwable $e) {
            DB::rollback();

            $contenidos = DB::table('ContenidoAbout')
                ->where('fechaBaja', NULL)
                ->where('estado', 1)->get();

            return view('backend.contenidoAbout.index', ['contenidos' => $contenidos]);
        }
    }

    public function destroyContenido($id)
    {
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
        $data['estado'] = 0;

        DB::table('ContenidoAbout')->where('id', $id)->update($data);

        $contenidos = DB::table('ContenidoAbout')
            ->where('fechaBaja', NULL)
            ->where('estado', 1)->get();

        return view('backend.contenidoAbout.index', ['contenidos' => $contenidos]);
    }

    public function registro()
    {
        $registros = DB::table('ComoRegistrarse')->get();
        return view(
            'backend.contenidoAbout.registrarseIndex',
            ['registros' => $registros]
        );
    }

    public function crearRegistro()
    {
        return view('backend.contenidoAbout.registrarseCrear');
    }

    public function guardarRegistro(Request $request,  ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            $data = array();
            if ($request->pdf== null) {
                $request->validate(['pdf' => 'required'], ['pdf.required' => '(*) Debe cargar un documento para descargar. ']);
            } else {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'ComoRegistrarse', 'ComoRegistrarse', 'pdf');
            }


            $data['titulo']         = $request->title;
            $data['descripcion']         = $request->descripcion;

            if ($request->status == 'on') {
                $data['estado'] = 1;

                //si lo creo activo tengo que desactivar cualquiera que este activo
                $activo = DB::table('ComoRegistrarse')->where('estado',1)->first();
                if(!empty($activo)){
                    $nuevoEstado['estado'] = 0;
                    DB::table('ComoRegistrarse')->where('id',$activo->id)->update($nuevoEstado);
                }
                
            } else {
                $data['estado'] = 0;
            }
            $data['fechaAlta']      = DB::raw('CURRENT_TIMESTAMP');


            DB::table('ComoRegistrarse')->insert($data);

            DB::commit();

            $registros = DB::table('ComoRegistrarse')->get();
            return view(
                'backend.contenidoAbout.registrarseIndex',
                ['registros' => $registros]
            );
        } catch (Throwable $e) {
            DB::rollback();

            $registros = DB::table('ComoRegistrarse')->get();
            return view(
                'backend.contenidoAbout.registrarseIndex',
                ['registros' => $registros]
            );
        }
    }

    public function editarRegistro($id)
    {
        $registro = DB::table('ComoRegistrarse')->where('id', $id)->first();

        return view(
            'backend.contenidoAbout.registrarseEdit',
            ['registro' => $registro]
        );
    }

    public function actualizarRegistro(Request $request, $id, ArchivoNombreCargadoService $serviceNombre){
        DB::beginTransaction();
        try {
            $data = array();
            if ($request->pdf!= null) {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf,'ComoRegistrarse', 'ComoRegistrarse', 'pdf');
            }


            $data['titulo']         = $request->title;
            $data['descripcion']         = $request->descripcion;


            if ($request->status == 'on') {
                $data['estado'] = 1;
                
                 //si lo creo edito tengo que desactivar cualquiera que este activo
                 $activo = DB::table('ComoRegistrarse')->where('estado',1)->first();
                 if(!empty($activo)){
                    $nuevoEstado['estado'] = 0;
                    DB::table('ComoRegistrarse')->where('id',$activo->id)->update($nuevoEstado);
                }
      
            } else {
                $data['estado'] = 0;
            }

            DB::table('ComoRegistrarse')->where('id', $id)->update($data);

            DB::commit();

            $registros = DB::table('ComoRegistrarse')->get();
            return view(
                'backend.contenidoAbout.registrarseIndex',
                ['registros' => $registros]
            );
        } catch (Throwable $e) {
            DB::rollback();

            $registros = DB::table('ComoRegistrarse')->get();
            return view(
                'backend.contenidoAbout.registrarseIndex',
                ['registros' => $registros]
            );
        }
    }
}
