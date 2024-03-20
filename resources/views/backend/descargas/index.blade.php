@extends('backend.app')

@section('content')
    <script>
        function alertDelete(form) {

            Swal.fire({
                title: "¿Estas seguro?",
                text: "Este cambio sera permanente!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, borrar!",
            }).then((result) => {
                if (result.value) {
                    //si presiona la tecla ok //ajax
                    $("#" + form).submit();
                } //if
            }); //.them
        }
    </script>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Descargas Excel</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la descarga de datos en formato Excel.</li>
        </ol>
        <div class="row" style="position: relative">
            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th style="width: 320px">Nombre</th>
                        <th>Contenido</th>
                        <th style="width: 200px" class="ml-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-botom-1px">
                        <th>Listado de Empresas y Entidades</th>
                        <th class="th-light">-Razón Social</br>
                            -Grupo</br>
                            -Actividad</br>
                            -Categoria</br>
                            -Rango de Venta</br>
                            -Rango de Personal</br>
                            -Avance Programa de Integridad</br>
                        </th>
                        <th>
                            <form action="{{ route('listadoEmpresas') }}" method="get" class="centrar-boton">
                                @csrf
                                <button type="submit" class="btn btn-success">Descargar</button>
                            </form>
                        </th>

                    </tr>

                    <tr class="border-botom-1px">
                        <th>Tipos de Empresas y Entidades</th>
                        <th class="th-light">-Cantidad de cada grupo de empresas y entidades registradas</br>
                        </th>
                        <th>
                            <form action="{{ route('cantidadxGrupo') }}" method="get" class="centrar-boton">
                                @csrf
                                <button type="submit" class="btn btn-success">Descargar</button>
                            </form>
                        </th>

                    </tr>

                    <tr class="border-botom-1px">
                        <th>Actividad de Empresas y Entidades</th>
                        <th class="th-light">-Cantidad de cada actividad de empresas y entidades registradas.</br>
                        </th>
                        <th>
                            <form action="{{ route('cantidadxActividad') }}" method="get" class="centrar-boton">
                                @csrf
                                <button type="submit" class="btn btn-success">Descargar</button>
                            </form>
                        </th>

                    </tr>


                    <tr class="border-botom-1px">
                        <th>Categoría de Empresas y Entidades</th>
                        <th class="th-light">-Cantidad de cada categoría de empresas y entidades registradas.
                        </th>
                        <th>
                            <form action="{{ route('cantidadxCategoria') }}" method="get" class="centrar-boton">
                                @csrf
                                <button type="submit" class="btn btn-success">Descargar</button>
                            </form>
                        </th>

                    </tr>


                    <tr class="border-botom-1px">
                        <th>Jurisdicción de Empresas y Entidades</th>
                        <th class="th-light">-Cantidad de empresas y entidades registradas en cada Jurisdicción.
                        </th>
                        <th>
                            <form action="{{ route('cantidadxJurisdiccion') }}" method="get" class="centrar-boton">
                                @csrf
                                <button type="submit" class="btn btn-success">Descargar</button>
                            </form>
                        </th>

                    </tr>

                    <tr class="border-botom-1px">
                        <th>Empresas/Entidades Export</th>
                        <th class="th-light">-Razón Social y fecha de alta de las Empresas/Entidades dadas de alta en el año seleccionado.
                        </th>
                        <th>
                            <form action="{{ route('usuariosExport') }}" method="get" class="centrar-boton">
                                @csrf
                                <div class="deparador-botones">
                                    <input type="number" name="year" class="seleccionar-year" placeholder="Año"
                                        id="year" onchange="habilitarDescarga()">
                                    <button type="submit" class="btn btn-success" id="button-usuariosExport"
                                        disabled>Descargar</button>
                                </div>
                            </form>
                        </th>

                    </tr>

                    <tr class="border-botom-1px">
                        <th>Respuestas cargadas</th>
                        <th class="th-light">-¿La organización realizó una evaluación de sus riesgos particulares? </br>
                            -¿Tiene la organización un Código de Ética/Conducta aprobado? </br>
                            -¿Qué áreas de la organización y/o terceras personas participaron del diseño del Código de
                            Etica/Conducta? </br>
                            -¿Contiene una mención explícita a la Tolerancia Cero a los delitos previstos en el art. 1° de
                            la Ley 27.401? </br>
                            -¿Existen reglas y procedimientos aprobadas específicamente dirigidas a guiar las interacciones
                            entre quienes integran la organización y quienes ejercen la función pública? </br>
                            -¿Algunas de estas reglas y procedimientos están dirigidos a evitar irregularidades en los
                            procesos de licitación y en la ejecución de contratos administrativos? </br>
                            -¿Están extendidas a terceras partes que representan a la organización en esa interacción? </br>
                            -¿Realiza la organización de algún tipo de capacitación general relativa al Programa de
                            Integridad? </br>
                            -¿Qué porcentaje de la nómina del personal actual fue entrenada en temas relativos al Código de
                            Ética en el último año? </br>
                            -¿A quién estuvo dirigida la capacitación? </br>
                            -¿Con qué periodicidad actualiza la formación del personal ya capacitado? </br>
                            -¿Tiene la organización un mecanismo de reporte como un canal o línea de integridad? </br>
                            -¿De qué manera se puede utilizar el canal? </br>
                        </th>
                        <th>
                            <form action="{{ route('descargarRespuestas') }}" method="get" class="centrar-boton">
                                @csrf
                                <button type="submit" class="btn btn-success">Descargar</button>
                            </form>
                        </th>

                    </tr>


                </tbody>
            </table>
        </div>
    </div>
@endsection
<style>
    .centrar-boton {
        margin-top: 50%;
        margin-bottom: 50%;
    }

    .table> :not(caption)>*>* {
        border-bottom-width: 0 !important;
    }

    .border-botom-1px {
        border-bottom: 1px solid black;
    }

    .th-light {
        color: gray;
        font-weight: 400;
    }

    /* Hide the up and down arrows */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<script>
    function isValid_Year(a) {
        if (a < 2000 || a > new Date().getFullYear()) {
            return false;
        }

        return true
    }

    function habilitarDescarga() {
        var button = document.getElementById('button-usuariosExport');
        var input = document.getElementById('year');

        if (isValid_Year(input.value)) {
            button.removeAttribute('disabled');
        } else {
            button.setAttribute('disabled', '');
        }

    }
</script>
