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
        <h1 class="mt-4">Card Rite en Números</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de tarjeta Rite en números</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('riteNumeros.create') }}" title="Create a question">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR UN REGISTRO
                </a>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
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
        <div class="row">

            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="ml-2">#</th>
                        <th scope="col">titulo</th>
                        <th scope="col">texto</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riteNumeros as $indexRiteNumero => $riteNumero)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $indexRiteNumero + 1 }}</span>
                            </th>
                            <th scope="row">
                                <span class="text-center ml-2 cita">{!! $riteNumero->titulo !!}</span>
                            </th>
                            <th scope="row">
                                <span class="text-center ml-2">{!! $riteNumero->texto !!}</span>
                            </th>
                            <th scope="row">
                                <img src="{{ asset(env('PATH_FILES') . "/riteNumeros/$riteNumero->imagen") }}"
                                    width="60">
                            </th>
                            <th scope="row">
                                @if ($riteNumero->estado == 1)
                                    <span class="text-center ml-2">Activa</span>
                                @else
                                    <span class="text-center ml-2">Inactiva</span>
                                @endif
                            </th>
                            <th>

                                <form id="form_riteNumero_{{ $riteNumero->id }}"
                                    action="{{ route('riteNumeros.destroy', $riteNumero->id) }}" method="POST">

                                    <a class="badge bg-warning" href="{{ route('riteNumeros.edit', $riteNumero->id) }}"><i
                                            class="fas fa-edit"></i> Editar</a>

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        onclick="javascript:alertDelete('form_riteNumero_{{ $riteNumero->id }}')"
                                        class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                                </form>

                            </th>

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
