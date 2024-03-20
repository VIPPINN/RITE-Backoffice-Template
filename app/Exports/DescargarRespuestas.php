<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class DescargarRespuestas implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        /*PREGUNTAS A AGREGAR */
        /*
           
            (Políticas y Procedimientos) Respuesta a pregunta: 
            (Políticas y Procedimientos) Respuesta a pregunta: 
            (Políticas y Procedimientos) Respuesta a pregunta: 
            (Políticas y Procedimientos) Respuesta a pregunta: 
            (Políticas y Procedimientos) Respuesta a pregunta: 
            (Capacitación y Comunicación) Respuesta a pregunta:
            (Capacitación y Comunicación) Respuesta a pregunta: 
            (Capacitación y Comunicación) Respuesta a pregunta:
            (Gestión del Canal de Integridad) Respuesta a pregunta: 
            (Gestión del Canal de Integridad) Respuesta a pregunta: 
        */
        $preguntas = [
           'Primera' => '¿La organización realizó una evaluación de sus riesgos particulares?',
           'Segunda' =>'¿Tiene la organización un Código de Ética/Conducta aprobado?',
           'Tercera' =>'¿Qué áreas de la organización y/o terceras personas participaron del diseño del Código de Etica/Conducta?',
           'Cuarta' =>'¿Contiene una mención explícita a la Tolerancia Cero a los delitos previstos en el art. 1° de la Ley 27.401?',
           'Quinta' =>'¿Existen reglas y procedimientos aprobadas específicamente dirigidas a guiar las interacciones entre quienes integran la organización y quienes ejercen la función pública?',
           'Sexta' =>'¿Algunas de estas reglas y procedimientos están dirigidos a evitar irregularidades en los procesos de licitación y en la ejecución de contratos administrativos?',
           'Septima' =>'¿Están extendidas a terceras partes que representan a la organización en esa interacción?',
           'Octava' =>'¿Realiza la organización de algún tipo de capacitación general relativa al Programa de Integridad?',
           'Novena' =>'¿Qué porcentaje de la nómina del personal actual fue entrenada en temas relativos al Código de Ética en el último año?',
           'Decima' => '¿A quién estuvo dirigida la capacitación?',
           'DecimaPrimera' =>'¿Con qué periodicidad actualiza la formación del personal ya capacitado?',
           'DecimaSegunda' => '¿Tiene la organización un mecanismo de reporte como un canal o línea de integridad?',
           'DecimaTercera' => '¿De qué manera se puede utilizar el canal?'
        ];
        
        $empresasPrueba = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
        $idPrueba = $empresasPrueba->id;
        $empresasAutorizado = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Autorizado%')->first();
        $idAutorizado = $empresasAutorizado->id;

        //obtengo todos los usuarios
        $result = DB::table('Usuario as u')
            ->where('idTipoPersona', 2)
            ->where('idGrupoUsuario', '!=', $idPrueba)
            ->where('idGrupoUsuario', '!=', $idAutorizado)
            ->where('u.fechaBaja', NULL)
            ->get();
        //obtengo todas las versiones del modulo de integridad
        $versionesInteggridad = DB::table('CuestionarioVersion')->where('idCuestionario', 1)->pluck('id');

        foreach ($result as $key => $empresa) {
            //busco la ultima presentaion estado presentado que tengo en idCuestioanrioVersion alguna de las versiones del modul ode integridad
            $presentacion = DB::table('Presentacion')
                ->where('idUsuario', $empresa->id)
                ->where('idEstadoPresentacion', 2)
                ->whereIn('idCuestionarioVersion', $versionesInteggridad)
                ->orderBy('id', 'desc')
                ->first();

            //si la encuentro busco las preguntas y guardo las respuestas
            //sino pongo que no tiene respuesta
            if ($presentacion) {
                foreach ($preguntas as $keyPregunta => $pregunta) {
                    $Pregunta = DB::table('Pregunta')
                        ->where('idCuestionarioVersion', $presentacion->idCuestionarioVersion)
                        ->where('pregunta', 'LIKE', '%' . $pregunta . '%')
                        ->first();

                    $idPregunta = $Pregunta->id;
                   
                    $respuesta = DB::table('Respuesta')->where('idPregunta', $idPregunta)->where('idPresentacion', $presentacion->id)->first();
                    if ($respuesta) {
                        //obtengo la pregunta
                        $tipoPregunta = DB::table('Pregunta')->where('id',$respuesta->idPregunta)->first();
                        //si la pregunta es tipo 4 = multiple
                        if($tipoPregunta->idTipoPregunta == 4){
                            //la opcion se guarda en el atributo valorNumerico
                            //busco en preguntaOpcion el valorNumerico
                            //genero una variable para guardar la concatenacion de respuestas
                            $valorRespuesta = "";
                            //busco todas las respuestas a esa pregunta
                            $respuestas = DB::table('Respuesta')->where('idPregunta',$respuesta->idPregunta)->where('idPresentacion',$presentacion->id)->get();
                            //itero sobre cada respuesta encontrada
                            foreach ($respuestas as $keyRespuesta => $respuesta) {
                                //busco la opcion correspondiente a la repsuesta
                                $valor = DB::table('PreguntaOpcion')->where('id',$respuesta->valorNumerico)->first();
                                //concateno las respuestas
                                $valorRespuesta = $valorRespuesta .  $valor->descripcion . " | ";
                            }
                            //lo asigno  a un atributo d ela empresa
                            $empresa->$keyPregunta = $valorRespuesta;
                        }else{
                            //la opcion se guarda en el atributo valorTexto
                            $empresa->$keyPregunta = $respuesta->valorTexto;
                        }
                    } else {
                        $empresa->$keyPregunta = 'Sin Responder';
                    }
                }
            } else {
                foreach ($preguntas as $keyPregunta => $pregunta) {
                    
                    $empresa->$keyPregunta = 'Sin Responder';
                }
            }
        }

        return view('backend.descargas.listadoRespuestas', [
            'empresas' => $result
        ]);
    }
}
