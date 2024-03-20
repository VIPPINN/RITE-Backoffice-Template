<?php

namespace App\Http\Controllers\backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;

class RiteNumerosController extends Controller
{
    public function riteNumerosIndex()
    {
        $registros = DB::table('RiteNumeros')
            ->join('TipoRiteNumeros', 'RiteNumeros.idTipo', 'TipoRiteNumeros.id')
            ->select(
                'RiteNumeros.id as id',
                'RiteNumeros.titulo as titulo',
                'RiteNumeros.descripcion as descripcion',
                'RiteNumeros.pdf as pdf',
                'RiteNumeros.miniatura as miniatura',
                'RiteNumeros.estado as estado',
                'TipoRiteNumeros.descripcion as tipo',
            )
            ->orderBy('TipoRiteNumeros.id','asc')
            ->get();
        return view(
            'backend.riteNumerosPantalla.index',
            ['registros' => $registros]
        );
    }

    public function agregarEstadistica()
    {
        $tipos = DB::table('TipoRiteNumeros')->get();

        return view('backend.riteNumerosPantalla.create', ['tipos' => $tipos]);
    }

    public function guardarEstadistica(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        $request->validate(
            [
                'titulo' => 'required',
                'descripcion' => 'required',
                'pdf' => 'required',
                'tipo' => 'required',

            ],
            [
                'titulo.required' => '(*) El titulo es requerido. Debe ingresarlo.',
                'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
                'pdf.required' => '(*) El archivo es requerido. Debe ingresarlo.',
                'tipo.required' => '(*) El tipo es requerido. Debe ingresarlo.',
            ]
        );

        $data = array();

        if ($request->status == 'on') {
            $data['estado'] = 1;
        } else {
            $data['estado'] = 0;
        }
        if ($request->miniatura) {
            $data['miniatura'] = $serviceNombre->GenerarNombre($request->miniatura, 'RiteNumero', 'RiteNumeros', 'miniatura');
        }
        $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'RiteNumero', 'RiteNumeros', 'pdf');
        $data['titulo'] = $request->titulo;
        $data['descripcion'] = $request->descripcion;
        $data['idTipo'] = $request->tipo;
        $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('RiteNumeros')->insert($data);

        $registros = DB::table('RiteNumeros')
            ->join('TipoRiteNumeros', 'RiteNumeros.idTipo', 'TipoRiteNumeros.id')
            ->select(
                'RiteNumeros.id as id',
                'RiteNumeros.titulo as titulo',
                'RiteNumeros.descripcion as descripcion',
                'RiteNumeros.pdf as pdf',
                'RiteNumeros.miniatura as miniatura',
                'RiteNumeros.estado as estado',
                'TipoRiteNumeros.descripcion as tipo',
            )
            ->orderBy('TipoRiteNumeros.id','asc')
            ->get();
        return view(
            'backend.riteNumerosPantalla.index',
            ['registros' => $registros]
        );
    }

    public function editarEstadistica($id)
    {
        $tipos = DB::table('TipoRiteNumeros')->get();
        $registro = DB::table('RiteNumeros')->where('id', $id)->first();

        return view('backend.riteNumerosPantalla.edit', [
            'tipos' => $tipos,
            'registro' => $registro
        ]);
    }

    public function actualizarEstadistica(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {

        DB::beginTransaction();
        try {
            if ($request->status == 'on') {
                $data['estado'] = 1;
            } else {
                $data['estado'] = 0;
            }
            if ($request->pdf) {
                $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'RiteNumero', 'RiteNumeros', 'pdf');
            }

            if ($request->miniatura) {
                $data['miniatura'] = $serviceNombre->GenerarNombre($request->miniatura, 'RiteNumero', 'RiteNumeros', 'miniatura');
            }

            if($request->tipo == 2){
                $data['miniatura'] = null;
            }

            $data['titulo'] = $request->titulo;
            $data['descripcion'] = $request->descripcion;
            $data['idTipo'] = $request->tipo;

            DB::table('RiteNumeros')->where('id', $id)->update($data);

            DB::commit();

            $registros = DB::table('RiteNumeros')
                ->join('TipoRiteNumeros', 'RiteNumeros.idTipo', 'TipoRiteNumeros.id')
                ->select(
                    'RiteNumeros.id as id',
                    'RiteNumeros.titulo as titulo',
                    'RiteNumeros.descripcion as descripcion',
                    'RiteNumeros.pdf as pdf',
                    'RiteNumeros.miniatura as miniatura',
                    'RiteNumeros.estado as estado',
                    'TipoRiteNumeros.descripcion as tipo',
                )
                ->orderBy('TipoRiteNumeros.id','asc')
                ->get();
            return view(
                'backend.riteNumerosPantalla.index',
                ['registros' => $registros]
            );
        } catch (\Throwable $t) {
            DB::rollBack();
            dd($t);
        }
    }
}
