<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class CantidadXCategoria implements FromView
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
        $categorias = DB::table('CategoriaEntidad')->get();

        $cantidades = [];
        $total = 0;
        foreach ($categorias as $keyGrupo => $categoria) {
            $cantidad = DB::table('Usuario')
                ->leftJoin('Clasificacion', 'Clasificacion.id', 'Usuario.idClasificacionUltima')
                ->leftJoin('CategoriaEntidad', 'Clasificacion.idCategoriaEntidad', 'CategoriaEntidad.id')
                ->where('Usuario.idGrupoUsuario', '!=', $idPrueba)
                ->where('Usuario.idGrupoUsuario', '!=', $idAutorizado)
                ->where('CategoriaEntidad.id', $categoria->id)->count();

            $cantidades[$categoria->descripcion] = $cantidad;
            $total = $total + $cantidad;
        }

        $empRegistradas =  DB::table('Usuario as u')
            ->where('idTipoPersona', 2)
            ->where('idGrupoUsuario', '!=', $idPrueba)
            ->where('idGrupoUsuario', '!=', $idAutorizado)
            ->where('u.fechaBaja', NULL)
            ->count();

        $noClasificadas = $empRegistradas - $total;


        return view('backend.descargas.cantidadXCategoria', [
            'categorias' => $categorias,
            'noClasificadas' => $noClasificadas,
            'cantidades' => $cantidades
        ]);
    }
}
