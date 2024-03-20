@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-primary"
                    href="{{ URL::to('/backend/cuestionarios/temas/' . $idTema->idCuestionarioVersion) }}">
                    Volver
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Preguntas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la visualización y carga de Preguntas</li>
        </ol>
        @if ($cuestionarioVersionEstado == 0)
            <div class="row mt-3 mb-3">
                <div class="col-sm-4 text-right">
                    <a class="btn btn-success" href="{{ URL::to('/backend/cuestionarios/crearPregunta/' . $idTema->id) }}"
                        title="Crear Tipo Entidad">
                        <i class="fas fa-plus-circle"></i>
                        AGREGAR PREGUNTA
                    </a>
                </div>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <!--<div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ $message }}
              </div> -->

            <script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Acción realizada correctamente",
                    showConfirmButton: false,
                    timer: 2000,
                });
            </script>
        @endif
        <div class="row" style="position: relative">
            <form action="{{ route('preguntas-show', ['id' => $idTema->id]) }}" method="GET">
                @csrf

                <div class="buscador-usuarios">
                    <input type="text" name="buscarPregunta" class="input-buscador" placeholder="Buscar pregunta"
                        value="{{ request('buscarPregunta') }}">

                </div>
                <button type="submit" class="buscar-usuario">Buscar</button>
            </form>
            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="text-center ml-2">#</th>
                        <th scope="col">Pregunta</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($preguntas as $index => $pregunta)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
                            </th>

                            <td>
                                <span class="ml-2">{!! $pregunta->pregunta !!}</span>
                            </td>



                            <td>
                                <span class="text-center ml-2">
                                    <form id="form_pregunta_{{ $pregunta->id }}"
                                        action="{{ route('pregunta-destroy', $pregunta->id) }}" method="POST">

                                        @if ($cuestionarioVersionEstado == 0)
                                            <a class="badge bg-warning"
                                                href="{{ URL::to('/backend/cuestionarios/editarPregunta/' . $pregunta->id) }}"><i
                                                    class="fas fa-edit"></i> Editar</a>
                                        @endif
                                        @if ($pregunta->impactoNivelAvance == 1)
                                            <a class="badge bg-primary"
                                                href="{{ URL::to('/backend/cuestionarios/temas/preguntas/opcionesImpactan/' . $pregunta->id) }}"><i
                                                    class="fas fa-edit"></i> Opciones Impactan</a>
                                        @else
                                            <a class="badge bg-primary"
                                                href="{{ URL::to('/backend/cuestionarios/temas/preguntas/opciones/' . $pregunta->id) }}"><i
                                                    class="fas fa-edit"></i> Opciones</a>
                                        @endif

                                        @if ($cuestionarioVersionEstado == 0)
                                            @csrf
                                            <button type="button"
                                                onclick="javascript:alertDelete('form_pregunta_{{ $pregunta->id }}')"
                                                class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                                        @endif
                                    </form>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>




    </div>
@endsection
<style>
    .input-buscador {
        position: absolute;
        top: -55px;
        right: 380px;
        height: 38px;
        width: 400px;
    }


    .input-buscador2 {
        position: absolute;
        top: -95px;
        right: 380px;
        height: 38px;
        width: 400px;
    }

    .buscar-usuario {
        position: absolute;
        top: -55px;
        right: 230px;
        height: 38px;
        border-radius: 5px;
        background-color: rgb(13, 110, 253);
        border: none;
        color: white;
        width: 150px;
    }

    .buscar-usuario:hover {
        border: 1px solid rgb(13, 110, 253);
        color: rgb(13, 110, 253);
        background-color: white;
    }
</style>


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
