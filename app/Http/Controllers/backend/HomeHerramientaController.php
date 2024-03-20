<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\ActividadEntidad;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Herramienta;
use App\Services\ArchivoNombreCargadoService;
use finfo;

class HomeHerramientaController extends Controller
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

    /*=======  Inicio parte de Ciudadania =========*/

    public function ciudadaniaIndex()
    {
        $herramientasCiudadania = DB::table('HerramientaCiudadania')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'HerramientaCiudadania.idHerramientaTipo')
            ->select(
                'HerramientaCiudadania.id as id',
                'HerramientaCiudadania.titulo as titulo',
                'HerramientaCiudadania.descripcion as descripcion',
                'HerramientaCiudadania.activo as activo',
                'HerramientaCiudadania.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('HerramientaCiudadania.fechaBaja', NULL)->get();

        return view(
            'backend.herramienta.ciudadania',
            ['herramientas' => $herramientasCiudadania]
        );
    }

    public function ciudadaniaCrear()
    {
        $tipoHerramientas = DB::table('HerramientaTipo')->where('descripcion', 'NOT LIKE', '%Acuerdos%')->get();
        return view(
            'backend.herramienta.ciudadaniaCrear',
            ['herramientaTipo' => $tipoHerramientas]
        );
    }

    public function ciudadaniaGuardar(Request $request)
    {
        try {
            $data['titulo'] = $request->titulo;
            $data['descripcion'] = $request->descripcion;
            $data['idHerramientaTipo'] = $request->tipo;
            if (!empty($request->estado)) {
                $data['activo'] = 1;
            } else {
                $data['activo'] = 0;
            }

            $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

            if ($request->link) {
                $data['linkVideo'] = $request->link;
            }

            DB::table('HerramientaCiudadania')->insert($data);
        } catch (\Throwable $t) {
            dd("error");
        }

        $herramientasCiudadania = DB::table('HerramientaCiudadania')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'HerramientaCiudadania.idHerramientaTipo')
            ->select(
                'HerramientaCiudadania.id as id',
                'HerramientaCiudadania.titulo as titulo',
                'HerramientaCiudadania.descripcion as descripcion',
                'HerramientaCiudadania.activo as activo',
                'HerramientaCiudadania.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('HerramientaCiudadania.fechaBaja', NULL)->get();

        return view(
            'backend.herramienta.ciudadania',
            ['herramientas' => $herramientasCiudadania]
        );
    }

    public function ciudadaniaEditar($id)
    {
        $herramienta = DB::table('HerramientaCiudadania')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'HerramientaCiudadania.idHerramientaTipo')
            ->select(
                'HerramientaCiudadania.id as id',
                'HerramientaCiudadania.titulo as titulo',
                'HerramientaCiudadania.descripcion as descripcion',
                'HerramientaCiudadania.activo as activo',
                'HerramientaCiudadania.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('HerramientaCiudadania.id', $id)
            ->first();

        $tipoHerramientas = DB::table('HerramientaTipo')
            ->where('descripcion', 'NOT LIKE', '%Acuerdos%')
            ->get();

        return view(
            'backend.herramienta.editarCiudadania',
            [
                'herramienta' => $herramienta,
                'herramientaTipo' => $tipoHerramientas
            ]
        );
    }

    public function ciudadaniaUpdate(Request $request, $id)
    {
        try {
            $data['titulo'] = $request->titulo;
            $data['descripcion'] = $request->descripcion;
            $data['idHerramientaTipo'] = $request->tipo;
            if ($request->estado == "on") {
                $data['activo'] = 1;
            } else {
                $data['activo'] = 0;
            }

            $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

            if ($request->link) {
                $data['linkVideo'] = $request->link;
            }

            DB::table('HerramientaCiudadania')->where('id', $id)->update($data);
        } catch (\Throwable $t) {
            dd("error");
        }

        $herramientasCiudadania = DB::table('HerramientaCiudadania')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'HerramientaCiudadania.idHerramientaTipo')
            ->select(
                'HerramientaCiudadania.id as id',
                'HerramientaCiudadania.titulo as titulo',
                'HerramientaCiudadania.descripcion as descripcion',
                'HerramientaCiudadania.activo as activo',
                'HerramientaCiudadania.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('HerramientaCiudadania.fechaBaja', NULL)->get();

        return view(
            'backend.herramienta.ciudadania',
            ['herramientas' => $herramientasCiudadania]
        );
    }

    public function ciudadaniaBorrar($id)
    {
        try {
            DB::table('HerramientaCiudadania')->where('id', $id)->delete();
        } catch (\Throwable $t) {
            dd("error");
        }

        $herramientasCiudadania = DB::table('HerramientaCiudadania')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'HerramientaCiudadania.idHerramientaTipo')
            ->select(
                'HerramientaCiudadania.id as id',
                'HerramientaCiudadania.titulo as titulo',
                'HerramientaCiudadania.descripcion as descripcion',
                'HerramientaCiudadania.activo as activo',
                'HerramientaCiudadania.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('HerramientaCiudadania.fechaBaja', NULL)->get();

        return view(
            'backend.herramienta.ciudadania',
            ['herramientas' => $herramientasCiudadania]
        );
    }

    /*=======  Fin parte de Ciudadania =========*/

    /*======= Inicio Herramientas Empresas =======*/

    public function empresaIndex()
    {
        $idGrupoEmpresa = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Empresa%')
            ->first();
        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEmpresa->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();
        return view(
            'backend.herramienta.empresas',
            ['herramientas' => $herramientas]
        );
    }

    public function empresaHerramientaCrear()
    {
        $tipoHerramientas = DB::table('HerramientaTipo')
            ->where('descripcion', 'NOT LIKE', '%Acuerdos%')
            ->get();



        return view(
            'backend.herramienta.empresaCrear',
            [
                'herramientaTipo' => $tipoHerramientas
            ]
        );
    }

    public function empresaHerramientaGuardar(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            if ($request->pdf) {
                $pdfNombre = $request->pdf->getClientOriginalName();
                $nombreArchivoSinExtension = str_replace('.pdf', '', $pdfNombre);
                $data['pdfNombre'] = $nombreArchivoSinExtension;
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Herramienta', 'Herramienta', 'pdf');
            }

            $data['titulo']            = $request->titulo;
            $data['descripcion']       = $request->descripcion;
            $data['linkVideo']         = $request->link;
            $data['idHerramientaTipo'] = $request->tipo;
            $data['activo']            = 1;

            //como es empresa busco el id en la tabla y lo cargo

            $idEmpresa = DB::table('GrupoEntidad')
                ->where('descripcion', 'LIKE', '%Empresa%')
                ->first();

            $data['idGrupoEntidad'] = $idEmpresa->id;

            DB::table('Herramienta')->insert($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd($t);
        }

        $idGrupoEmpresa = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Empresa%')
            ->first();
        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEmpresa->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();
        return view(
            'backend.herramienta.empresas',
            ['herramientas' => $herramientas]
        );
    }

    public function empresaHerramientaListado()
    {
        
        $empresas = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%mpresa%')
            ->orWhere('descripcion', 'LIKE', '%ECPE%')
            ->pluck('id');

        $hayFormularios = DB::table('FormulariosCajaHerramientas')->count();
        if ($hayFormularios != 0) {
            $formulariosEmpresas = DB::table('FormulariosCajaHerramientas')
                ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
                ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
                ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
                ->select(
                    'FormulariosCajaHerramientas.id as id',
                    'GrupoEntidad.descripcion as descripcion',
                    'CategoriaEntidad.descripcion as categoria',
                    'SostenibleCuestionario.titulo as cuestionario',
                    'FormulariosCajaHerramientas.pdf as pdf'
                )
                ->whereIn('idGrupoEntidad', $empresas)
                ->get();

            return view(
                'backend.herramienta.formulariosEmpresasIndex',
                ['formularios' => $formulariosEmpresas]
            );
        } else {
            $formulariosEmpresas = [];
            return view('backend.herramienta.formulariosEmpresasIndex', ['formularios' => $formulariosEmpresas]);
        }
    }

    public function empresaForularioCrear()
    {
        $empresas = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%mpresa%')
            ->orWhere('descripcion', 'LIKE', '%ECPE%')
            ->get();

        $tamaños = DB::table('CategoriaEntidad')->get();

        $cuestionarios = DB::table('SostenibleCuestionario')
            ->get();

        return view(
            'backend.herramienta.formulariosEmpresasCrear',
            [
                'empresas' => $empresas,
                'tamaños' => $tamaños,
                'cuestionarios' => $cuestionarios
            ]
        );
    }

    public function formularioEmpresaGuardar(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            if (!empty($request->file('pdf'))) {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->file('pdf'), 'FormulariosCajaHerramientas', 'FormulariosCajaHerramientas', 'pdf');
            }

            $data['idGrupoEntidad'] = $request->tipo;
            $data['idCategoriaEntidad'] = $request->tamaño;
            $data['idCuestionario'] = $request->cuestionario;

            DB::table('FormulariosCajaHerramientas')->insert($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd("error al guardar formulario par aempresa");
        }

        $empresas = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%mpresa%')
            ->orWhere('descripcion', 'LIKE', '%ECPE%')
            ->pluck('id');

        $formulariosEmpresas = DB::table('FormulariosCajaHerramientas')
            ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
            ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
            ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
            ->select(
                'FormulariosCajaHerramientas.id as id',
                'GrupoEntidad.descripcion as descripcion',
                'CategoriaEntidad.descripcion as categoria',
                'SostenibleCuestionario.titulo as cuestionario',
                'FormulariosCajaHerramientas.pdf as pdf'
            )
            ->whereIn('idGrupoEntidad', $empresas)
            ->get();

        return view(
            'backend.herramienta.formulariosEmpresasIndex',
            ['formularios' => $formulariosEmpresas]
        );
    }

    public function empresaHerramientaEditar($id)
    {
        $herramienta = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.linkVideo as linkVideo',
                'Herramienta.pdf as pdf',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('Herramienta.id', $id)
            ->first();

        $tipoHerramientas = DB::table('HerramientaTipo')
            ->where('descripcion', 'NOT LIKE', '%Acuerdos%')
            ->get();

        return view(
            'backend.herramienta.editarHerramientaEmpresa',
            [
                'herramienta' => $herramienta,
                'herramientaTipo' => $tipoHerramientas
            ]
        );
    }

    public function empresaHerramientaUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {

        DB::beginTransaction();
        try {
            if ($request->pdf) {
                $pdfNombre = $request->pdf->getClientOriginalName();
                $nombreArchivoSinExtension = str_replace('.pdf', '', $pdfNombre);
                $data['pdfNombre'] = $nombreArchivoSinExtension;
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Herramienta', 'Herramienta', 'pdf');
            }

            $data['titulo']            = $request->titulo;
            $data['descripcion']       = $request->descripcion;
            $data['linkVideo']         = $request->link;
            $data['idHerramientaTipo'] = $request->tipo;
            if ($request->estado == null) {
                $data['activo'] = 0;
            } else {
                $data['activo'] = 1;
            }

            //como es empresa busco el id en la tabla y lo cargo

            $idEmpresa = DB::table('GrupoEntidad')
                ->where('descripcion', 'LIKE', '%Empresa%')
                ->first();

            $data['idGrupoEntidad'] = $idEmpresa->id;

            DB::table('Herramienta')->where('id', $id)->update($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd($t);
        }

        $idGrupoEmpresa = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Empresa%')
            ->first();
        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEmpresa->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();
        return view(
            'backend.herramienta.empresas',
            ['herramientas' => $herramientas]
        );
    }

    public function empresaHerramientaBorrar($id)
    {

        try {
            DB::table('Herramienta')->where('id', $id)->delete();
        } catch (\Throwable $t) {
            dd("error");
        }

        $idGrupoEmpresa = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Empresa%')
            ->first();
        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEmpresa->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();
        return view(
            'backend.herramienta.empresas',
            ['herramientas' => $herramientas]
        );
    }

    public function empresaFormularioEditar($id)
    {
        $formulario = DB::table('FormulariosCajaHerramientas')
            ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
            ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
            ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
            ->select(
                'FormulariosCajaHerramientas.id as id',
                'GrupoEntidad.descripcion as descripcion',
                'CategoriaEntidad.descripcion as categoria',
                'SostenibleCuestionario.titulo as cuestionario',
                'FormulariosCajaHerramientas.pdf as pdf'
            )
            ->where('FormulariosCajaHerramientas.id', $id)
            ->first();

        $empresas = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%mpresa%')
            ->orWhere('descripcion', 'LIKE', '%ECPE%')
            ->get();

        $tamaños = DB::table('CategoriaEntidad')->get();

        $cuestionarios = DB::table('SostenibleCuestionario')
            ->get();

        return view(
            'backend.herramienta.empresasFormularioEditar',
            [
                'formulario' =>  $formulario,
                'empresas' => $empresas,
                'tamaños' => $tamaños,
                'cuestionarios' => $cuestionarios
            ]
        );
    }

    public function formularioEmpresaUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            if ($request->pdf) {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'FormulariosCajaHerramientas', 'FormulariosCajaHerramientas', 'pdf');
            }

            $data['idGrupoEntidad']            = $request->tipo;
            $data['idCategoriaEntidad']       = $request->tamaño;
            $data['idCuestionario']         = $request->cuestionario;



            DB::table('FormulariosCajaHerramientas')->where('id', $id)->update($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd($t);
        }

        $empresas = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%mpresa%')
            ->orWhere('descripcion', 'LIKE', '%ECPE%')
            ->pluck('id');

        $formulariosEmpresas = DB::table('FormulariosCajaHerramientas')
            ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
            ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
            ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
            ->select(
                'FormulariosCajaHerramientas.id as id',
                'GrupoEntidad.descripcion as descripcion',
                'CategoriaEntidad.descripcion as categoria',
                'SostenibleCuestionario.titulo as cuestionario',
                'FormulariosCajaHerramientas.pdf as pdf'
            )
            ->whereIn('idGrupoEntidad', $empresas)
            ->get();

        return view(
            'backend.herramienta.formulariosEmpresasIndex',
            ['formularios' => $formulariosEmpresas]
        );
    }

    /*Inicio herramientas entidades*/
    public function entidadIndex()
    {

        $idGrupoEntidad = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Entidad%')
            ->first();

        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEntidad->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();

        return view('backend.herramienta.entidades', ['herramientas' => $herramientas]);
    }

    public function entidadHerramientaCrear()
    {
        $tipoHerramientas = DB::table('HerramientaTipo')
            ->where('descripcion', 'NOT LIKE', '%Acuerdos%')
            ->get();



        return view(
            'backend.herramienta.entidadCrear',
            [
                'herramientaTipo' => $tipoHerramientas
            ]
        );
    }

    public function entidadHerramientaGuardar(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            if ($request->pdf) {
                $pdfNombre = $request->pdf->getClientOriginalName();
                $nombreArchivoSinExtension = str_replace('.pdf', '', $pdfNombre);
                $data['pdfNombre'] = $nombreArchivoSinExtension;
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Herramienta', 'Herramienta', 'pdf');
            }

            $data['titulo']            = $request->titulo;
            $data['descripcion']       = $request->descripcion;
            $data['linkVideo']         = $request->link;
            $data['idHerramientaTipo'] = $request->tipo;
            $data['activo']            = 1;

            //como es empresa busco el id en la tabla y lo cargo

            $idEntidad = DB::table('GrupoEntidad')
                ->where('descripcion', 'LIKE', '%Entidad%')
                ->first();

            $data['idGrupoEntidad'] = $idEntidad->id;

            DB::table('Herramienta')->insert($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd($t);
        }

        $idGrupoEntidad = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Entidad%')
            ->first();

        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEntidad->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();

        return view(
            'backend.herramienta.entidades',
            ['herramientas' => $herramientas]
        );
    }

    public function entidadHerramientaListado()
    {

        $entidades = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%ntidad%')
            ->orWhere('descripcion', 'LIKE', '%rganizaci%')
            ->pluck('id');

        $hayFormularios = DB::table('FormulariosCajaHerramientas')->count();
        if ($hayFormularios != 0) {
            $formulariosEntidades = DB::table('FormulariosCajaHerramientas')
                ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
                ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
                ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
                ->select(
                    'FormulariosCajaHerramientas.id as id',
                    'GrupoEntidad.descripcion as descripcion',
                    'CategoriaEntidad.descripcion as categoria',
                    'SostenibleCuestionario.titulo as cuestionario',
                    'FormulariosCajaHerramientas.pdf as pdf'
                )
                ->whereIn('idGrupoEntidad', $entidades)
                ->get();

            return view(
                'backend.herramienta.formulariosEntidadIndex',
                ['formularios' => $formulariosEntidades]
            );
        } else {
            $formulariosEntidades = [];
            return view('backend.herramienta.formulariosEntidadIndex', ['formularios' => $formulariosEntidades]);
        }
    }

    public function entidadForularioCrear()
    {
        $entidades = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%ntidad%')
            ->orWhere('descripcion', 'LIKE', '%rganizaci%')
            ->get();

        $tamaños = DB::table('CategoriaEntidad')->get();

        $cuestionarios = DB::table('SostenibleCuestionario')
            ->get();

        return view(
            'backend.herramienta.formulariosEntidadCrear',
            [
                'entidades' => $entidades,
                'tamaños' => $tamaños,
                'cuestionarios' => $cuestionarios
            ]
        );
    }

    public function formularioEntidadGuardar(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            if (!empty($request->file('pdf'))) {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->file('pdf'), 'FormulariosCajaHerramientas', 'FormulariosCajaHerramientas', 'pdf');
            }

            $data['idGrupoEntidad'] = $request->tipo;
            $data['idCategoriaEntidad'] = $request->tamaño;
            $data['idCuestionario'] = $request->cuestionario;

            DB::table('FormulariosCajaHerramientas')->insert($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd("error al guardar formulario para entidad");
        }

        $entidades = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%ntidad%')
            ->orWhere('descripcion', 'LIKE', '%rganizaci%')
            ->pluck('id');

        $formulariosEntidades = DB::table('FormulariosCajaHerramientas')
            ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
            ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
            ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
            ->select(
                'FormulariosCajaHerramientas.id as id',
                'GrupoEntidad.descripcion as descripcion',
                'CategoriaEntidad.descripcion as categoria',
                'SostenibleCuestionario.titulo as cuestionario',
                'FormulariosCajaHerramientas.pdf as pdf'
            )
            ->whereIn('idGrupoEntidad', $entidades)
            ->get();

        return view(
            'backend.herramienta.formulariosEntidadIndex',
            ['formularios' => $formulariosEntidades]
        );
    }

    public function entidadHerramientaEditar($id)
    {
        $herramienta = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.linkVideo as linkVideo',
                'Herramienta.pdf as pdf',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('Herramienta.id', $id)
            ->first();

        $tipoHerramientas = DB::table('HerramientaTipo')
            ->where('descripcion', 'NOT LIKE', '%Acuerdos%')
            ->get();

        return view(
            'backend.herramienta.editarHerramientaEntidad',
            [
                'herramienta' => $herramienta,
                'herramientaTipo' => $tipoHerramientas
            ]
        );
    }

    public function entidadHerramientaUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {

        DB::beginTransaction();
        try {
            if ($request->pdf) {
                $pdfNombre = $request->pdf->getClientOriginalName();
                $nombreArchivoSinExtension = str_replace('.pdf', '', $pdfNombre);
                $data['pdfNombre'] = $nombreArchivoSinExtension;
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Herramienta', 'Herramienta', 'pdf');
            }

            $data['titulo']            = $request->titulo;
            $data['descripcion']       = $request->descripcion;
            $data['linkVideo']         = $request->link;
            $data['idHerramientaTipo'] = $request->tipo;
            if ($request->estado == null) {
                $data['activo'] = 0;
            } else {
                $data['activo'] = 1;
            }


            //como es empresa busco el id en la tabla y lo cargo

            $idEntidad = DB::table('GrupoEntidad')
                ->where('descripcion', 'LIKE', '%Entidad%')
                ->first();

            $data['idGrupoEntidad'] = $idEntidad->id;

            DB::table('Herramienta')->where('id', $id)->update($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd($t);
        }

        $idGrupoEntidad = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Entidad%')
            ->first();

        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEntidad->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();
        return view(
            'backend.herramienta.entidades',
            ['herramientas' => $herramientas]
        );
    }

    public function entidadHerramientaBorrar($id)
    {

        try {
            DB::table('Herramienta')->where('id', $id)->delete();
        } catch (\Throwable $t) {
            dd("error");
        }

        $idGrupoEntidad = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%Entidad%')
            ->first();

        $herramientas = DB::table('Herramienta')
            ->join('HerramientaTipo', 'HerramientaTipo.id', 'Herramienta.idHerramientaTipo')
            ->select(
                'Herramienta.id as id',
                'Herramienta.titulo as titulo',
                'Herramienta.descripcion as descripcion',
                'Herramienta.activo as activo',
                'Herramienta.pdf as pdf',
                'Herramienta.linkVideo as linkVideo',
                'HerramientaTipo.descripcion as descripcionTipo'
            )
            ->where('idGrupoEntidad', $idGrupoEntidad->id)
            ->where('Herramienta.fechaBaja', NULL)
            ->get();

        return view('backend.herramienta.entidades', ['herramientas' => $herramientas]);
    }

    public function entidadFormularioEditar($id)
    {
        $formulario = DB::table('FormulariosCajaHerramientas')
            ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
            ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
            ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
            ->select(
                'FormulariosCajaHerramientas.id as id',
                'GrupoEntidad.descripcion as descripcion',
                'CategoriaEntidad.descripcion as categoria',
                'SostenibleCuestionario.titulo as cuestionario',
                'FormulariosCajaHerramientas.pdf as pdf'
            )
            ->where('FormulariosCajaHerramientas.id', $id)
            ->first();

        $entidades = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%ntidad%')
            ->orWhere('descripcion', 'LIKE', '%rganizaci%')
            ->get();

        $tamaños = DB::table('CategoriaEntidad')->get();

        $cuestionarios = DB::table('SostenibleCuestionario')
            ->get();

        return view(
            'backend.herramienta.entidadFormularioEditar',
            [
                'formulario' =>  $formulario,
                'entidades' => $entidades,
                'tamaños' => $tamaños,
                'cuestionarios' => $cuestionarios
            ]
        );
    }

    public function formularioEntidadUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        DB::beginTransaction();
        try {
            if ($request->pdf) {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'FormulariosCajaHerramientas', 'FormulariosCajaHerramientas', 'pdf');
            }

            $data['idGrupoEntidad']            = $request->tipo;
            $data['idCategoriaEntidad']       = $request->tamaño;
            $data['idCuestionario']         = $request->cuestionario;



            DB::table('FormulariosCajaHerramientas')->where('id', $id)->update($data);
            DB::commit();
        } catch (\Throwable $t) {
            DB::rollback();
            dd($t);
        }
        $entidades = DB::table('GrupoEntidad')
            ->where('descripcion', 'LIKE', '%ntidad%')
            ->orWhere('descripcion', 'LIKE', '%rganizaci%')
            ->pluck('id');

        $formulariosEntidades = DB::table('FormulariosCajaHerramientas')
            ->join('GrupoEntidad', 'GrupoEntidad.id', 'FormulariosCajaHerramientas.idGrupoEntidad')
            ->join('CategoriaEntidad', 'CategoriaEntidad.id', 'FormulariosCajaHerramientas.idCategoriaEntidad')
            ->join('SostenibleCuestionario', 'SostenibleCuestionario.id', 'FormulariosCajaHerramientas.idCuestionario')
            ->select(
                'FormulariosCajaHerramientas.id as id',
                'GrupoEntidad.descripcion as descripcion',
                'CategoriaEntidad.descripcion as categoria',
                'SostenibleCuestionario.titulo as cuestionario',
                'FormulariosCajaHerramientas.pdf as pdf'
            )
            ->whereIn('idGrupoEntidad', $entidades)
            ->get();

        return view(
            'backend.herramienta.formulariosEntidadIndex',
            ['formularios' => $formulariosEntidades]
        );
    }
}
