<?php

namespace app\Services;

use App\Models\Recurso;
use Illuminate\Support\Facades\DB;

class FiltroService
{
    public function filtroEstado($estado, $tabla)
    {
        return $resp = $estado == 9 
            ? DB::table("$tabla")->paginate(10) 
            : DB::table("$tabla")->where('estado',$estado)->paginate(10);
    }

    public function filtroEstadoOrdenado($estado, $tabla)
    {
        return $resp = $estado == 9 
            ? DB::table("$tabla")->orderBy('estado','desc')->orderBy('orden')->paginate(10) 
            : DB::table("$tabla")->where('estado',$estado)->orderBy('estado')->orderBy('orden')->paginate(10);
    }

    public function filtroEstadoRecurso($estado)
    {
        if($estado == 9) 
        {
            return $resp = Recurso::filter()
            ->join('tipoRecurso', 'tipoRecurso.id', '=', 'recursos.idTipoRecurso')
            ->join('origenRecurso', 'origenRecurso.id', '=', 'recursos.idOrigenRecurso')
            ->join('temaRecurso','temaRecurso.id','=','recursos.idTemaRecurso')
            ->select(
                'recursos.id AS id',
                'recursos.titulo AS titulo',
                'recursos.descripcion AS descripcion',
                'recursos.enlaceDescarga AS descarga',
                'recursos.estado AS status',
                'tipoRecurso.titulo AS tipoRecursoTitulo',
                'origenRecurso.titulo AS origenRecursoTitulo',
                'temaRecurso.titulo AS temaRecursoTitulo'
            )
            ->paginate(10);
        }
        else 
        {
            return $resp = Recurso::filter()
                ->join('tipoRecurso', 'tipoRecurso.id', '=', 'recursos.idTipoRecurso')
                ->join('origenRecurso', 'origenRecurso.id', '=', 'recursos.idOrigenRecurso')
                ->join('temaRecurso','temaRecurso.id','=','recursos.idTemaRecurso')
                ->select(
                    'recursos.id AS id',
                    'recursos.titulo AS titulo',
                    'recursos.descripcion AS descripcion',
                    'recursos.enlaceDescarga AS descarga',
                    'recursos.estado AS status',
                    'tipoRecurso.titulo AS tipoRecursoTitulo',
                    'origenRecurso.titulo AS origenRecursoTitulo',
                    'temaRecurso.titulo AS temaRecursoTitulo'
                )
                ->where('recursos.estado', $estado)
                ->paginate(10);
        }
    }
}