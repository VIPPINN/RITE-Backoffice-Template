<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoriaEntidad;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeBuscarUsuarioController extends Controller
{
    public function indexUsuario(Request $request)
    {

        $query = $request->get('buscarUsuario'); // Obtener el término de búsqueda
        $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Usuario Simulacion%')->first();
        $idGrupoSimulacion = $grupoSimulacion->id;
        $usuarios = DB::table('Usuario')
            ->join('TipoPersona', 'Usuario.idTipoPersona', '=', 'TipoPersona.id')
            ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
            ->select(
                'Usuario.id as id',
                'nombre',
                'apellido',
                'idTipoPersona',
                'CUIT',
                'email',
                'emailSecundario',
                'fechaAlta',
                'fechaBaja',
                'GrupoUsuario.descripcion as grupo'
            )
            ->where('idTipoPersona', '=', 1) // Filtrar por idTipoPersona igual a 1
            ->where(function ($queryBuilder) use ($idGrupoSimulacion, $query) {
                $queryBuilder->where('nombre', 'LIKE', "%$query%")
                ->orWhere('apellido', 'LIKE', "%$query%")
                ->orWhere('CUIT', 'LIKE', "%$query%")
                ->orWhere('email', 'LIKE', "%$query%");
            })
            ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
            ->get();


        foreach ($usuarios as $usuario) {
            $usuario->roles = DB::table('model_has_roles')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('model_has_roles.model_id', $usuario->id)
                ->pluck('roles.name')
                ->toArray();
        }

        return view('backend.usuarios.index', [
            'usuarios' => $usuarios
        ]);
    }

    public function indexEmpresa(Request $request)
    {

        $query = $request->get('buscarUsuario'); // Obtener el término de búsqueda
        $grupoSimulacion = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
        $idGrupoSimulacion = $grupoSimulacion->id;

        $usuarios = DB::table('Usuario')
            ->join('GrupoUsuario', 'Usuario.idGrupoUsuario', '=', 'GrupoUsuario.id')
            ->leftjoin('Clasificacion', 'Usuario.idClasificacionUltima', '=', 'Clasificacion.id')
            ->leftjoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', '=', 'CategoriaEntidad.id')
            ->leftjoin('Provincias', 'Usuario.idProvincia', '=', 'Provincias.id')
            ->select(
                'Usuario.id as id',
                'CUIT',
                'razonSocial',
                'idTipoPersona',
                'email',
                'emailSecundario',
                'nombreFantasia',
                'esPionera',
                'Usuario.fechaAlta as fechaAlta',
                'Usuario.fechaBaja as fechaBaja',
                'GrupoUsuario.descripcion as grupo',
                'CategoriaEntidad.descripcion as categoria',
                'Provincias.nombre as nombreProvincia'
            )
            ->where('idTipoPersona', '=', 2)
            ->where(function ($queryBuilder) use ($idGrupoSimulacion, $query) {
                $queryBuilder->where('razonSocial', 'LIKE', "%$query%")
                    ->orWhere('CUIT', 'LIKE', "%$query%")
                    ->orWhere('email', 'LIKE', "%$query%");
            })
            ->where('Usuario.idGrupoUsuario', '!=', $idGrupoSimulacion)
            ->get();



        return view('backend.empresas.index', [
            'usuarios' => $usuarios
        ]);
    }

    public function indexDelegar(Request $request)
    {
        if ($request->get('buscarUsuario')) {
            $query = $request->get('buscarUsuario'); // Obtener el término de búsqueda
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
                ->where('u1.Nombre', 'LIKE', "%$query%")
                ->orWhere('u1.apellido', 'LIKE', "%$query%")
                ->get();


            foreach ($relaciones as $index => $relacion) {

                $empresa = DB::table('Usuario')->select('razonSocial', 'fechaBaja')->where('id', '=', $relacion->idUsuarioQueDelega)->first();
                $relacion->razonSocial = $empresa->razonSocial;
            }
        }
        if ($request->get('buscarEmpresa')) {
            $query = $request->get('buscarEmpresa'); // Obtener el término de búsqueda

            $relaciones = DB::table('Usuario as u1')
                ->join('UsuarioDelegado as ud', 'ud.idUsuarioQueDelega', '=', 'u1.id')
                ->select(
                    'u1.razonSocial as razonSocial',
                    'ud.idUsuarioDelegado as idUsuarioDelegado',
                    'ud.fechaAlta as fechaAlta',
                    'ud.fechaBaja as fechaBaja',
                    'ud.id as id'
                )
                ->where('u1.razonSocial', 'LIKE', "%$query%")
                ->get();


            foreach ($relaciones as $index => $relacion) {

                $usuario = DB::table('Usuario')->select('nombre', 'apellido')->where('id', '=', $relacion->idUsuarioDelegado)->first();
                $relacion->nombre = $usuario->nombre;
                $relacion->apellido = $usuario->apellido;
            }
        }




        return view('backend.delegar.index', ['relaciones' => $relaciones]);
    }
}
