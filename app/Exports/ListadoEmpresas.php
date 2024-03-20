<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class ListadoEmpresas implements FromView
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

        $result = DB::table('Usuario as u')
            ->leftJoin('Clasificacion as cl', 'cl.id', 'u.idClasificacionUltima')
            ->leftJoin('RangoVenta as rv', 'rv.id', 'cl.idRangoVenta')
            ->leftJoin('RangoPersonal as rp', 'rp.id', 'cl.idRangoPersonal')
            ->leftJoin('GrupoEntidad as ge', 'ge.id', 'cl.idGrupoEntidad')
            ->leftJoin('CategoriaEntidad as ce', 'ce.id', 'cl.idCategoriaEntidad')
            ->leftJoin('ActividadEntidad as ae', 'ae.id', 'cl.idActividadEntidad')
            ->select(
                'u.id as idUsuario',
                'u.razonSocial',
                'ge.descripcion as Grupo',
                'ae.descripcion as Actividad',
                'ce.descripcion as Categoria',
                'rv.limiteVentaTotalAnualInicial as RangoVentaInicial',
                'rv.limiteVentaTotalAnualFinal as RangoVentaFinal',
                'rp.limitePersonalOcupadoInicial as RangoPersonalInicial',
                'rp.limitePersonalOcupadoFinal as RangoPersonalFinal'
            )
            ->where('idTipoPersona', 2)
            ->where('idGrupoUsuario', '!=', $idPrueba)
            ->where('idGrupoUsuario', '!=', $idAutorizado)
            ->where('u.fechaBaja', NULL)
            ->get();

        
        //busco la version activa del modulo de integridad
        $versionActiva = DB::table('CuestionarioVersion')->where('estadoAoI', 1)->where('idCuestionario', 1)->first();
        $idVersionActiva = $versionActiva->id;

        //itero sobre los resultados para obtener las cantidades en cada nivel
        foreach ($result as $key => $item) {
            //busco primero la categoria de la entidad
            $idCategoriaEntidad = DB::table('Usuario')
                ->leftjoin('clasificacion', 'Usuario.idClasificacionUltima', '=', 'clasificacion.id')
                ->leftjoin('categoriaEntidad', 'clasificacion.idCategoriaEntidad', '=', 'categoriaEntidad.id')
                ->select('categoriaEntidad.id as idCategoria')
                ->where('Usuario.id', '=', $item->idUsuario)
                ->orderBy('Clasificacion.id', 'desc')
                ->first();

            //luego busco el grupo al que pertenece
            $idGrupoEntidad = DB::table('Usuario')
                ->leftjoin('clasificacion', 'Usuario.idClasificacionUltima', '=', 'clasificacion.id')
                ->select('clasificacion.idGrupoEntidad as grupo')
                ->where('Usuario.id', '=', $item->idUsuario)
                ->first();

            if ($idGrupoEntidad->grupo == 4) {
                $idGrupoEntidad->grupo = 1;
            }

            //obtengo los totales para cada empresa registrada
            $TotalModeradoIntegridad = DB::table('PreguntaNivel')
                ->Join('Pregunta', 'PreguntaNivel.idPregunta', '=', 'Pregunta.id')
                ->where('idGrupoEntidad', $idGrupoEntidad->grupo)
                ->where('idCategoriaEntidad', $idCategoriaEntidad->idCategoria)
                ->where('impactoNivelAvance', 1)
                ->where('idNivel', 1)
                ->where('Pregunta.idCuestionarioVersion', '=', $versionActiva->id)
                ->count();
            $TotalMedioedioIntegridad  = DB::table('PreguntaNivel')
                ->Join('Pregunta', 'PreguntaNivel.idPregunta', '=', 'Pregunta.id')
                ->where('idGrupoEntidad', $idGrupoEntidad->grupo)
                ->where('idCategoriaEntidad', $idCategoriaEntidad->idCategoria)
                ->where('impactoNivelAvance', 1)
                ->where('idNivel', 2)
                ->where('Pregunta.idCuestionarioVersion', '=', $versionActiva->id)
                ->count();
            $TotalAvanzadoIntegridad  = DB::table('PreguntaNivel')
                ->Join('Pregunta', 'PreguntaNivel.idPregunta', '=', 'Pregunta.id')
                ->where('idGrupoEntidad', $idGrupoEntidad->grupo)
                ->where('idCategoriaEntidad', $idCategoriaEntidad->idCategoria)
                ->where('impactoNivelAvance', 1)
                ->where('idNivel', 3)
                ->where('Pregunta.idCuestionarioVersion', '=', $versionActiva->id)
                ->count();
            $item->totalModerado = $TotalModeradoIntegridad;
            $item->totalMedio = $TotalMedioedioIntegridad;
            $item->totalAvanzado =  $TotalAvanzadoIntegridad;

            //busco su ultima presentacion
            $idPresentacion = DB::table('Presentacion')
                ->join('CuestionarioVersion', 'CuestionarioVersion.id', 'Presentacion.idCuestionarioVersion')
                ->join('Cuestionario', 'Cuestionario.id', 'CuestionarioVersion.idCuestionario')
                ->select('Presentacion.id')
                ->where('idUsuario', $item->idUsuario)
                ->where('idEstadoPresentacion', 2)
                ->where('Cuestionario.id', 1)
                ->orderBy('Presentacion.id', 'desc')
                ->first();

            //valido si encuentra presentacion realizada
            if (!$idPresentacion) {
                //si no encuentra sus respuestas son 0 en avance
                $item->respuestaModerado = 0;
                $item->respuestaMedio = 0;
                $item->respuestaAvanzado =  0;
            } else {

                $versionActiva = DB::table('Presentacion')
                    ->join('CuestionarioVersion', 'CuestionarioVersion.id', 'Presentacion.idCuestionarioVersion')
                    ->join('Cuestionario', 'Cuestionario.id', 'CuestionarioVersion.idCuestionario')
                    ->select('CuestionarioVersion.id')
                    ->where('Presentacion.idEstadoPresentacion', '=', 2)
                    ->where('Cuestionario.id', 1)
                    ->where('Presentacion.idUsuario', $item->idUsuario)
                    ->orderBy('Presentacion.id', 'desc')
                    ->first();


                //si encuentra busco las cantidades que impactan cada nivel
                $respuestaModerado = DB::select(DB::raw(
                    "select count(Respuesta.id) as cantidad FROM Presentacion join Respuesta on Presentacion.id = Respuesta.idPresentacion
                      join Pregunta on Pregunta.id = Respuesta.idPregunta
                      join PreguntaNivel on PreguntaNivel.idPregunta = Pregunta.id
                      left join OpcionPreguntaImpacta on Pregunta.id = OpcionPreguntaImpacta.idPregunta
                        where Respuesta.valorTexto = OpcionPreguntaImpacta.opcion 
                        and Pregunta.idCuestionarioVersion = $versionActiva->id
                        and Presentacion.idUsuario = $item->idUsuario
                        and Pregunta.impactoNivelAvance = 1
                        and PreguntaNivel.idCategoriaEntidad = $idCategoriaEntidad->idCategoria
                        and PreguntaNivel.idGrupoEntidad = $idGrupoEntidad->grupo
                        and idNivel = 1
                        and Presentacion.id = " . $idPresentacion->id
                ));


                $respuestaModerado = $respuestaModerado[0]->cantidad;

                $respuestaMedio = DB::select(DB::raw(
                    "select count(Respuesta.id) as cantidad FROM Presentacion join Respuesta on Presentacion.id = Respuesta.idPresentacion
                    join Pregunta on Pregunta.id = Respuesta.idPregunta
                    join PreguntaNivel on PreguntaNivel.idPregunta = Pregunta.id
                    left join OpcionPreguntaImpacta on Pregunta.id = OpcionPreguntaImpacta.idPregunta
                      where Respuesta.valorTexto = OpcionPreguntaImpacta.opcion 
                      and Pregunta.idCuestionarioVersion = $versionActiva->id
                      and Presentacion.idUsuario = $item->idUsuario
                      and Pregunta.impactoNivelAvance = 1
                      and PreguntaNivel.idCategoriaEntidad = $idCategoriaEntidad->idCategoria
                      and PreguntaNivel.idGrupoEntidad = $idGrupoEntidad->grupo
                      and idNivel = 2
                      and Presentacion.id = " . $idPresentacion->id
                ));

                $respuestaMedio = $respuestaMedio[0]->cantidad;

                $respuestaAvanzado = DB::select(DB::raw(
                    "select count(Respuesta.id) as cantidad FROM Presentacion join Respuesta on Presentacion.id = Respuesta.idPresentacion
                    join Pregunta on Pregunta.id = Respuesta.idPregunta
                    join PreguntaNivel on PreguntaNivel.idPregunta = Pregunta.id
                    left join OpcionPreguntaImpacta on Pregunta.id = OpcionPreguntaImpacta.idPregunta
                      where Respuesta.valorTexto = OpcionPreguntaImpacta.opcion 
                      and Pregunta.idCuestionarioVersion = $versionActiva->id
                      and Presentacion.idUsuario = $item->idUsuario
                      and Pregunta.impactoNivelAvance = 1
                      and PreguntaNivel.idCategoriaEntidad = $idCategoriaEntidad->idCategoria
                      and PreguntaNivel.idGrupoEntidad = $idGrupoEntidad->grupo
                      and idNivel = 3
                      and Presentacion.id = " . $idPresentacion->id
                ));
                $respuestaAvanzado = $respuestaAvanzado[0]->cantidad;

                $item->respuestaModerado = $respuestaModerado;
                $item->respuestaMedio = $respuestaMedio;
                $item->respuestaAvanzado =  $respuestaAvanzado;
            }
        }

        return view('backend.descargas.listadoEmpresas', [
            'empresas' => $result
        ]);
    }
}
