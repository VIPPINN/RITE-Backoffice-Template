<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ListadoEmpresas;
use App\Exports\CantidadXGrupo;
use App\Exports\CantidadXActividad;
use App\Exports\MultipleUsuariosExport;
use App\Exports\ListadoCompletoEmpresas;
use App\Exports\CantidadxCategoria;
use App\Exports\CantidadxJurisdiccion;
use App\Exports\DescargarRespuestas;
use Maatwebsite\Excel\Facades\Excel;


class HomeDescargasExcelController extends Controller
{
    public function index()
    {
        return view('backend.descargas.index');
    }

    public function listadoEmpresas()
    {
        return Excel::download(new ListadoEmpresas, 'listado.xlsx');
    }

    public function cantidadxGrupo()
    {
        return Excel::download(new CantidadXGrupo, 'cantidadXGrupo.xlsx');
    }

    public function cantidadxActividad()
    {
        return Excel::download(new CantidadXActividad, 'cantidadXActividad.xlsx');
    }

    public function usuariosExport(Request $request)
    {
        return (new MultipleUsuariosExport($request->year))->download('registroEmpresas.xlsx');
    }

    public function listadoCompletoEmpresas()
    {
        return Excel::download(new ListadoCompletoEmpresas, 'listadoCompletoEmpresas.xlsx');
    }

    public function cantidadxCategoria()
    {
        return Excel::download(new CantidadXCategoria, 'cantidadXCategoria.xlsx');
    }

    public function cantidadxJurisdiccion()
    {
        return Excel::download(new CantidadxJurisdiccion, 'cantidadxJurisdiccion.xlsx');
    }

    public function descargarRespuestas()
    {
        return Excel::download(new DescargarRespuestas, 'respuestas.xlsx');
    }
}
