<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class CantidadXGrupo implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $empresasPrueba = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
        $idPrueba = $empresasPrueba->id;
        $empresasAutorizado = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Autorizado%')->first();
        $idAutorizado = $empresasAutorizado->id;
        $grupos = DB::table('GrupoEntidad')->get();

        $cantidades = [];
        $total = 0;
        foreach ($grupos as $keyGrupo => $grupo) {
            $cantidad = DB::table('Usuario')
            ->leftJoin('Clasificacion','Clasificacion.id','Usuario.idClasificacionUltima')
            ->leftJoin('GrupoEntidad','Clasificacion.idGrupoEntidad','GrupoEntidad.id')
            ->where('Usuario.idGrupoUsuario','!=',$idPrueba)
            ->where('Usuario.idGrupoUsuario','!=',$idAutorizado)
            ->where('GrupoEntidad.id',$grupo->id)->count();

            $cantidades[$grupo->descripcion] = $cantidad;
            $total = $total + $cantidad;
        }

        $empRegistradas =  DB::table('Usuario as u')
        ->where('idTipoPersona', 2)
        ->where('idGrupoUsuario', '!=', $idPrueba)
        ->where('idGrupoUsuario', '!=', $idAutorizado)
        ->where('u.fechaBaja', NULL)
        ->count();

        $noClasificadas = $empRegistradas - $total;


        return view('backend.descargas.cantidadXGrupo', [
            'grupos' => $grupos,
            'noClasificadas' => $noClasificadas,
            'cantidades' => $cantidades
        ]);
    }
}
