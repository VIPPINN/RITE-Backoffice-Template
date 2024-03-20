<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class CantidadXJurisdiccion implements FromView
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
        $jurisdicciones = DB::table('Provincias')->get();
       
        $cantidades = [];
        $total = 0;
        foreach ($jurisdicciones as $keyGrupo => $jurisdiccion) {
            $cantidad = DB::table('Usuario')
                ->where('Usuario.idGrupoUsuario', '!=', $idPrueba)
                ->where('Usuario.idGrupoUsuario', '!=', $idAutorizado)
                ->where('Usuario.idProvincia', $jurisdiccion->id)->count();

            $cantidades[$jurisdiccion->nombre] = $cantidad;
            $total = $total + $cantidad;
        }

        $empRegistradas =  DB::table('Usuario as u')
            ->where('idTipoPersona', 2)
            ->where('idGrupoUsuario', '!=', $idPrueba)
            ->where('idGrupoUsuario', '!=', $idAutorizado)
            ->where('u.fechaBaja', NULL)
            ->count();

        $noClasificadas = $empRegistradas - $total;


        return view('backend.descargas.cantidadXJurisdiccion', [
            'jurisdicciones' => $jurisdicciones,
            'noClasificadas' => $noClasificadas,
            'cantidades' => $cantidades
        ]);
    }
}
