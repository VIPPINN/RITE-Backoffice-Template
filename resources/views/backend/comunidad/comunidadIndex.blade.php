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
        <h1 class="mt-4">Comunidad</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de Comunidad</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('comunidadCreate') }}" title="Create a question">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR UN REGISTRO
                </a>
            </div>
        </div>

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
        <div class="row">

            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="ml-2">#</th>
                        <th scope="col">titulo</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Video</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comunidades as $indexComunidad => $comunidad)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $indexComunidad + 1 }}</span>
                            </th>
                            <td scope="row">
                                <span class="text-center ml-2">{{ $comunidad->titulo }}</span>
                            </td>
                            <td scope="row">
                                <span class="text-center ml-2">{{ $comunidad->fecha }}</span>
                            </td>
                            <td scope="row">
                                <span class="text-center ml-2">
                                    <a href="https://www.youtube.com/watch?v={{ $comunidad->video }}" class="video"
                                        target="_blank">ver</a>
                            </td>
                            <td scope="row">
                                <a class="badge bg-warning" href="{{ route('comunidadEditar', $comunidad->id) }}"><i
                                        class="fas fa-edit"></i> Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    @endsection

    <style>
        /* Estilo para limitar el ancho de la columna "Cita" */
        .table th:nth-child(2),
        .table td:nth-child(2) {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cita {
            word-wrap: break-word;
        }
    </style>
