<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RangoVentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidad = DB::table('GrupoEntidad')->where('descripcion', 'LIKE', '%Entidad%')->first();
        $entidadId = $entidad->id;
        $pequenia = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Peque%')->first();
        $pequeniaId = $pequenia->id;
        $media = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Mediana%')->first();
        $mediaId = $media->id;
        $grande = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Grande%')->first();
        $grandeId = $grande->id;

        $consultaPequenia = DB::table('RangoVenta')
            ->join('GrupoEntidad', 'RangoVenta.idGrupoEntidad', '=', 'GrupoEntidad.id')
            ->select('RangoVenta.limiteVentaTotalAnualInicial', 'RangoVenta.limiteVentaTotalAnualFinal')
            ->where('idCategoriaEntidad', $pequeniaId)
            ->where('idGrupoEntidad', $entidadId)
            ->first();

        $consultaMediana = DB::table('RangoVenta')
            ->join('GrupoEntidad', 'RangoVenta.idGrupoEntidad', '=', 'GrupoEntidad.id')
            ->select('RangoVenta.limiteVentaTotalAnualInicial', 'RangoVenta.limiteVentaTotalAnualFinal')
            ->where('idCategoriaEntidad', $mediaId)
            ->where('idGrupoEntidad', $entidadId)
            ->first();

        $consultaGrande = DB::table('RangoVenta')
            ->join('GrupoEntidad', 'RangoVenta.idGrupoEntidad', '=', 'GrupoEntidad.id')
            ->select('RangoVenta.limiteVentaTotalAnualInicial', 'RangoVenta.limiteVentaTotalAnualFinal')
            ->where('idCategoriaEntidad', $grandeId)
            ->where('idGrupoEntidad', $entidadId)
            ->first();

        $rangos = [];

        $consultaPequenia->tamanio = "Micro/Pequeña";
        $consultaMediana->tamanio = "Mediana";
        $consultaGrande->tamanio = "Grande";

        if ($consultaPequenia) {
            $rangos[1] = (array) $consultaPequenia;
        }

        if ($consultaMediana) {
            $rangos[2] = (array) $consultaMediana;
        }

        if ($consultaGrande) {
            $rangos[3] = (array) $consultaGrande;
        }

        return view('backend.entidad.index', [
            'rangos' => $rangos
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entidad = DB::table('GrupoEntidad')->where('descripcion', 'LIKE', '%Entidad%')->first();
        $entidadId = $entidad->id;
        $pequenia = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Peque%')->first();
        $pequeniaId = $pequenia->id;
        $valorActual = DB::table('RangoVenta')->where('idGrupoEntidad', $entidadId)->where('idCategoriaEntidad', $pequeniaId)->select('limiteVentaTotalAnualFinal as valor')->first();

        return view('backend.entidad.edit', [
            'valorActual' => $valorActual
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nuevoValorFinalPequenia = $request->valorMonotributoH;
        $nuevoValorInicialMeidana = $nuevoValorFinalPequenia + 1;
        $nuevoValorFinalMeidana = $nuevoValorFinalPequenia * 10;
        $nuevoValorInicialGrande =  $nuevoValorFinalMeidana + 1;

        $categorias = DB::table('CategoriaEntidad')->get();
        $actividades = DB::table('ActividadEntidad')->get();
        $grupo = DB::table('GrupoEntidad')->where('descripcion', 'LIKE', '%Entidad%')->first();
        $entidadId = $grupo->id;

        $pequenia = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Peque%')->first();
        $pequeniaId = $pequenia->id;
        $media = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Mediana%')->first();
        $mediaId = $media->id;
        $grande = DB::table('CategoriaEntidad')->where('descripcion', 'LIKE', '%Grande%')->first();
        $grandeId = $grande->id;

        foreach ($categorias as $keyC => $categoria) {

            foreach ($actividades as $keyA => $actividad) {
                //comienoz la transaccion
                DB::beginTransaction();
                if ($categoria->id ==  $pequeniaId) {

                    $data['limiteVentaTotalAnualFinal'] = $nuevoValorFinalPequenia;
                    try {
                        DB::table('RangoVenta')->where('idCategoriaEntidad', $pequeniaId)->where('idActividadEntidad', $actividad->id)->where('idGrupoEntidad',  $entidadId)->update($data);
                    } catch (\Error $e) {
                        //si hay algun error hago rollback
                        DB::rollback();
                    }
                }
                if ($categoria->id ==  $mediaId) {
                    $data['limiteVentaTotalAnualInicial'] = $nuevoValorInicialMeidana;
                    $data['limiteVentaTotalAnualFinal'] = $nuevoValorFinalMeidana;
                    try {
                        DB::table('RangoVenta')->where('idCategoriaEntidad', $mediaId)->where('idActividadEntidad', $actividad->id)->where('idGrupoEntidad',  $entidadId)->update($data);
                    } catch (\Error $e) {
                        //si hay algun error hago rollback
                        DB::rollback();
                    }
                }

                if ($categoria->id ==   $grandeId) {
                    $data['limiteVentaTotalAnualInicial'] = $nuevoValorInicialGrande;
                    $data['limiteVentaTotalAnualFinal'] = NULL;
                    try {
                        DB::table('RangoVenta')->where('idCategoriaEntidad', $grandeId)->where('idActividadEntidad', $actividad->id)->where('idGrupoEntidad',  $entidadId)->update($data);
                    } catch (\Error $e) {
                        //si hay algun error hago rollback
                        DB::rollback();
                    }
                }
                //si no hay error hago commit
                DB::commit();
            }
        }

        //devuelvo a la vista index
        return redirect()->route('rangos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
