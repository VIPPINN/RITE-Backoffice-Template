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
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-primary" href="{{ URL::to('/backend/sostenible/') }}">
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Cuestionarios </h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la visualización y carga de Cuestionarios en tarjeta de Inicio
            </li>
        </ol>

        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success"
                    href="{{ URL::to('/backend/sostenible-cuestionarios/crear-cuestionarios/' . $idSostenible) }}"
                    title="Crear Tema Cuestionario">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR CUESTIONARIO
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
                        <th scope="col" class="text-center ml-2">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Color</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cuestionarios)
                        @foreach ($cuestionarios as $index => $cuestionario)
                            <tr>
                                <th scope="row">
                                    <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
                                </th>

                                <td>
                                    <span class="ml-2">{{ $cuestionario->titulo }}</span>
                                </td>
                                <td>
                                    <span class="ml-2">{!! $cuestionario->texto !!}</span>
                                </td>
                                <td>
                                    <div style="background: {{ $cuestionario->color }};width:30px;height:30px;border-radius:50%">

                                    </div>
                                </td>

                                <td>
                                    <span class="text-center ml-2">
                                        <form method="POST">
                                            <a class="badge bg-warning" href="{{ URL::to('/backend/sostenible-cuestionarios/editar-cuestionarios/' . $cuestionario->id) }}"><i class="fas fa-edit"></i>
                                                Editar</a>


                                            @csrf
                                            <button type="button" onclick="" class="badge bg-danger"><i
                                                    class="fas fa-edit"></i> Borrar</button>

                                        </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>



    </div>

@endsection
