<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class CantidadXActividad implements FromView
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
        $actividades = DB::table('ActividadEntidad')->get();

        $cantidades = [];
        $total = 0;
        foreach ($actividades as $keyGrupo => $actividad) {
            $cantidad = DB::table('Usuario')
                ->leftJoin('Clasificacion', 'Clasificacion.id', 'Usuario.idClasificacionUltima')
                ->leftJoin('ActividadEntidad', 'Clasificacion.idActividadEntidad', 'ActividadEntidad.id')
                ->where('Usuario.idGrupoUsuario', '!=', $idPrueba)
                ->where('Usuario.idGrupoUsuario', '!=', $idAutorizado)
                ->where('ActividadEntidad.id', $actividad->id)->count();

            $cantidades[$actividad->descripcion] = $cantidad;
            $total = $total + $cantidad;
        }

        $empRegistradas =  DB::table('Usuario as u')
            ->where('idTipoPersona', 2)
            ->where('idGrupoUsuario', '!=', $idPrueba)
            ->where('idGrupoUsuario', '!=', $idAutorizado)
            ->where('u.fechaBaja', NULL)
            ->count();

        $noClasificadas = $empRegistradas - $total;


        return view('backend.descargas.cantidadXActividad', [
            'actividades' => $actividades,
            'noClasificadas' => $noClasificadas,
            'cantidades' => $cantidades
        ]);
    }
}
