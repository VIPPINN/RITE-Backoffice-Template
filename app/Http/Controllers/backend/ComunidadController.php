<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComunidadController extends Controller
{
    /*Comunidad*/
    public function comunidadIndex()
    {
        $tipoComunidad = DB::table('TipoComunidad')
            ->where('descripcion', 'LIKE', '%Comunidad%')
            ->first();

        $comunidades = DB::table('Comunidad')
            ->select('id', 'video', 'titulo', DB::raw("CONVERT(date, fecha) as fecha"))
            ->where('idTipoComunidad', $tipoComunidad->id)
            ->get();
        if (env('ENTORNO') == 'produccion') {
            foreach ($comunidades as $comunidad) {
                $fechaFormateada = Carbon::createFromFormat('M d Y h:i:s:A', $comunidad->fecha)->format('Y/m/d');

                $comunidad->fecha = $fechaFormateada;
            }
        }


        return view(
            'backend.comunidad.comunidadIndex',
            ['comunidades' => $comunidades]
        );
    }

    public function comunidadCreate()
    {

        return view('backend.comunidad.comunidadCreate');
    }

    public function comunidadStore(Request $request)
    {
        $tipoComunidad = DB::table('TipoComunidad')
            ->where('descripcion', 'LIKE', '%Comunidad%')
            ->first();

        $data['titulo'] = $request->title;
        $data['video'] = $request->video;
        $data['fecha'] = $request->fecha;
        $data['idTipoComunidad'] = $tipoComunidad->id;

        DB::table('Comunidad')->insert($data);

        $comunidades = DB::table('Comunidad')
            ->select('id', 'video', 'titulo', DB::raw("CONVERT(date, fecha) as fecha"))
            ->where('idTipoComunidad', $tipoComunidad->id)
            ->get();

        return view(
            'backend.comunidad.comunidadIndex',
            ['comunidades' => $comunidades]
        );
    }

    public function comunidadEditar($id)
    {
        $comunidad = DB::table('Comunidad')
            ->select('id', 'video', 'titulo', DB::raw("CONVERT(date, fecha) as fecha"))
            ->where('id', $id)
            ->first();

        return view(
            'backend.comunidad.comunidadEdit',
            ['comunidad' => $comunidad]
        );
    }

    public function comunidadUpdate(Request $request, $id)
    {

        $data['titulo'] = $request->title;
        $data['video'] = $request->video;
        $data['fecha'] = $request->fecha;

        DB::table('Comunidad')->where('id', $id)->update($data);

        $tipoComunidad = DB::table('TipoComunidad')
            ->where('descripcion', 'LIKE', '%Comunidad%')
            ->first();

        $comunidades = DB::table('Comunidad')
            ->select('id', 'video', 'titulo', DB::raw("CONVERT(date, fecha) as fecha"))
            ->where('idTipoComunidad', $tipoComunidad->id)
            ->get();

        return view(
            'backend.comunidad.comunidadIndex',
            ['comunidades' => $comunidades]
        );
    }

    /*Agenda*/
    public function agendaIndex()
    {
        $idAgenda = DB::table('TipoComunidad')->where('descripcion', 'LIKE', '%Agenda%')->first();

        $agendas = DB::table('Comunidad')
            ->join('Modalidades', 'Modalidades.id', 'Comunidad.idModalidad')
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Modalidades.descripcion as modalidad'
            )
            ->where('idTipoComunidad', $idAgenda->id)
            ->get();

        if (env('ENTORNO') == 'produccion') {
            foreach ($agendas as $agenda) {
                $fechaFormateada = Carbon::createFromFormat('M d Y h:i:s:A', $agenda->fecha)->format('Y/m/d');

                $agenda->fecha = $fechaFormateada;
            }
        }



        return view(
            'backend.comunidad.agendaIndex',
            ['agendas' => $agendas]
        );
    }

    public function agendaCreate()
    {
        $modalidades = DB::table('Modalidades')->get();
        return view(
            'backend.comunidad.agendaCreate',
            ['modalidades' => $modalidades]
        );
    }

    public function agendaStore(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        $request->validate(
            [
                'title' => 'required',
                'descripcion' => 'required',
                'imagepc' => 'required',
                'modalidad' => 'required',
                'hora' => 'required',
                'fecha' => 'required'
            ],
            [
                'title.required' => '(*) El titulo es requerido. Debe ingresarlo.',
                'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
                'imagepc.required' => '(*) La imagen es requerida. Debe ingresarla.',
                'modalidad.required' => '(*) La modalidad es requerida. Debe ingresarla.',
                'hora.required' => '(*) La hora es requerida. Debe ingresarla.',
                'fecha.required' => '(*) La fecha es requerida. Debe ingresarla.',
            ]
        );

        $idAgenda = DB::table('TipoComunidad')->where('descripcion', 'LIKE', '%Agenda%')->first();

        $data['imagen'] = $serviceNombre->GenerarNombre($request->imagepc, 'Comunidad', 'Comunidad', 'imagen');
        $data['titulo'] = $request->title;
        $data['descripcion'] = $request->descripcion;
        $data['idModalidad'] = $request->modalidad;
        $data['fecha'] = $request->fecha;
        $data['hora'] = $request->hora;
        $data['idTipoComunidad'] = $idAgenda->id;

        DB::table('Comunidad')->insert($data);

        $agendas = DB::table('Comunidad')
            ->join('Modalidades', 'Modalidades.id', 'Comunidad.idModalidad')
            ->where('idTipoComunidad', $idAgenda->id)
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Modalidades.descripcion as modalidad'
            )
            ->get();
        return view(
            'backend.comunidad.agendaIndex',
            ['agendas' => $agendas]
        );
    }

    public function agendaEditar($id)
    {
        $agenda = DB::table('Comunidad')
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Comunidad.idModalidad as idModalidad'
            )
            ->where('id', $id)->first();
        $modalidades = DB::table('Modalidades')->get();

        return view(
            'backend.comunidad.agendaEdit',
            [
                'agenda' => $agenda,
                'modalidades' => $modalidades
            ]
        );
    }

    public function agendaUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        $idAgenda = DB::table('TipoComunidad')->where('descripcion', 'LIKE', '%Agenda%')->first();

        if ($request->imagepc) {
            $data['imagen'] = $serviceNombre->GenerarNombre($request->imagepc, 'Comunidad', 'Comunidad', 'imagen');
        }

        $data['titulo'] = $request->title;
        $data['descripcion'] = $request->descripcion;
        $data['idModalidad'] = $request->modalidad;
        $data['fecha'] = $request->fecha;
        $data['hora'] = $request->hora;
        $data['idTipoComunidad'] = $idAgenda->id;

        DB::table('Comunidad')->where('id', $id)->update($data);

        $agendas = DB::table('Comunidad')
            ->join('Modalidades', 'Modalidades.id', 'Comunidad.idModalidad')
            ->where('idTipoComunidad', $idAgenda->id)
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Modalidades.descripcion as modalidad'
            )
            ->get();
        return view(
            'backend.comunidad.agendaIndex',
            ['agendas' => $agendas]
        );
    }

    /*Formación*/
    public function formacionIndex()
    {
        $idFormacion = DB::table('TipoComunidad')->where('descripcion', 'LIKE', '%Formacion%')->first();

        $formaciones = DB::table('Comunidad')
            ->join('Modalidades', 'Modalidades.id', 'Comunidad.idModalidad')
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Modalidades.descripcion as modalidad'
            )
            ->where('idTipoComunidad', $idFormacion->id)
            ->get();



        if (env('ENTORNO') == 'produccion') {
            foreach ($formaciones as $formacion) {
                $fechaFormateada = Carbon::createFromFormat('M d Y h:i:s:A', $formacion->fecha)->format('Y/m/d');

                $formacion->fecha = $fechaFormateada;
            }
        }


        return view(
            'backend.comunidad.formacionIndex',
            ['formaciones' => $formaciones]
        );
    }

    public function formacionCreate()
    {
        $modalidades = DB::table('Modalidades')->get();
        return view(
            'backend.comunidad.formacionCreate',
            ['modalidades' => $modalidades]
        );
    }

    public function formacionStore(Request $request, ArchivoNombreCargadoService $serviceNombre)
    {
        $request->validate(
            [
                'title' => 'required',
                'descripcion' => 'required',
                'imagepc' => 'required',
                'modalidad' => 'required',
                'hora' => 'required',
                'fecha' => 'required'
            ],
            [
                'title.required' => '(*) El titulo es requerido. Debe ingresarlo.',
                'descripcion.required' => '(*) La descripción es requerida. Debe ingresarla.',
                'imagepc.required' => '(*) La imagen es requerida. Debe ingresarla.',
                'modalidad.required' => '(*) La modalidad es requerida. Debe ingresarla.',
                'hora.required' => '(*) La hora es requerida. Debe ingresarla.',
                'fecha.required' => '(*) La fecha es requerida. Debe ingresarla.',
            ]
        );

        $idFormacion = DB::table('TipoComunidad')->where('descripcion', 'LIKE', '%Formacion%')->first();

        $data['imagen'] = $serviceNombre->GenerarNombre($request->imagepc, 'Comunidad', 'Comunidad', 'imagen');
        $data['titulo'] = $request->title;
        $data['descripcion'] = $request->descripcion;
        $data['idModalidad'] = $request->modalidad;
        $data['fecha'] = $request->fecha;
        $data['hora'] = $request->hora;
        $data['idTipoComunidad'] = $idFormacion->id;

        DB::table('Comunidad')->insert($data);

        $formaciones = DB::table('Comunidad')
            ->join('Modalidades', 'Modalidades.id', 'Comunidad.idModalidad')
            ->where('idTipoComunidad', $idFormacion->id)
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Modalidades.descripcion as modalidad'
            )
            ->get();
        return view(
            'backend.comunidad.formacionIndex',
            ['formaciones' => $formaciones]
        );
    }

    public function formacionEditar($id)
    {
        $formacion = DB::table('Comunidad')
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Comunidad.idModalidad as idModalidad'
            )
            ->where('id', $id)->first();
        $modalidades = DB::table('Modalidades')->get();

        return view(
            'backend.comunidad.formacionEdit',
            [
                'formacion' => $formacion,
                'modalidades' => $modalidades
            ]
        );
    }

    public function formacionUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        $idFormacion = DB::table('TipoComunidad')->where('descripcion', 'LIKE', '%Formacion%')->first();

        if ($request->imagepc) {
            $data['imagen'] = $serviceNombre->GenerarNombre($request->imagepc, 'Comunidad', 'Comunidad', 'imagen');
        }

        $data['titulo'] = $request->title;
        $data['descripcion'] = $request->descripcion;
        $data['idModalidad'] = $request->modalidad;
        $data['fecha'] = $request->fecha;
        $data['hora'] = $request->hora;
        $data['idTipoComunidad'] = $idFormacion->id;

        DB::table('Comunidad')->where('id', $id)->update($data);

        $formaciones = DB::table('Comunidad')
            ->join('Modalidades', 'Modalidades.id', 'Comunidad.idModalidad')
            ->where('idTipoComunidad', $idFormacion->id)
            ->select(
                'Comunidad.id as id',
                'Comunidad.titulo as titulo',
                'Comunidad.descripcion as descripcion',
                DB::raw("CONVERT(date, fecha) as fecha"),
                DB::raw("LEFT(CONVERT(varchar, hora, 108), 5) as hora"),
                'Comunidad.imagen as imagen',
                'Modalidades.descripcion as modalidad'
            )
            ->get();
        return view(
            'backend.comunidad.formacionIndex',
            ['formaciones' => $formaciones]
        );
    }

    /*Acuerdos*/
    public function acuerdosIndex()
    {
        $idAcuerdos = DB::table('TipoComunidad')
            ->where('descripcion', 'LIKE', '%Acuerdos%')
            ->first();

        $acuerdos = DB::table('comunidad')
            ->where('idTipoComunidad', $idAcuerdos->id)
            ->get();
        return view(
            'backend.comunidad.acuerdosIndex',
            ['acuerdos' => $acuerdos]
        );
    }

    public function acuerdosCreate()
    {
        return view('backend.comunidad.acuerdoCreate');
    }

    public function acuerdosStore(Request $request,  ArchivoNombreCargadoService $serviceNombre)
    {
        $request->validate(
            [
                'title' => 'required',
                'pdf' => 'required'
            ],
            [
                'title.required' => '(*) El titulo es requerido. Debe ingresarlo.',
                'pdf.required' => '(*) El archivo pdf es requerido. Debe ingresarlo.',
            ]
        );

        $idAcuerdos = DB::table('TipoComunidad')
            ->where('descripcion', 'LIKE', '%Acuerdos%')
            ->first();
        $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Comunidad', 'Comunidad', 'pdf');
        $data['titulo'] = $request->title;
        $data['idTipoComunidad'] = $idAcuerdos->id;

        DB::table('Comunidad')->insert($data);



        $acuerdos = DB::table('comunidad')
            ->where('idTipoComunidad', $idAcuerdos->id)
            ->get();
        return view(
            'backend.comunidad.acuerdosIndex',
            ['acuerdos' => $acuerdos]
        );
    }

    public function acuerdosEditar($id)
    {
        $acuerdo = DB::table('Comunidad')
            ->where('id', $id)
            ->first();

        return view(
            'backend.comunidad.acuerdoEdit',
            ['acuerdo' => $acuerdo]
        );
    }

    public function acuerdosUpdate(Request $request, $id, ArchivoNombreCargadoService $serviceNombre)
    {
        if ($request->pdf) {
            $data['pdf'] = $serviceNombre->GenerarNombre($request->pdf, 'Comunidad', 'Comunidad', 'pdf');
        }

        $data['titulo'] = $request->title;

        DB::table('Comunidad')->where('id', $id)->update($data);

        $idAcuerdos = DB::table('TipoComunidad')
            ->where('descripcion', 'LIKE', '%Acuerdos%')
            ->first();

        $acuerdos = DB::table('comunidad')
            ->where('idTipoComunidad', $idAcuerdos->id)
            ->get();
        return view(
            'backend.comunidad.acuerdosIndex',
            ['acuerdos' => $acuerdos]
        );
    }
}
