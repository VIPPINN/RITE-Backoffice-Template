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
        <h1 class="mt-4">RITE en Números</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de Informes y Estadísticas</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('agregarEstadistica') }}" title="Crear Herramienta">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR
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
        <div class="row" style="position:relative">

            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="text-center ml-2">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Archivo</th>
                        <th scope="col">Miniatura</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $indexRegistro => $registro)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $indexRegistro + 1 }}</span>
                            </th>
                            <td scope="row">
                                <span class="text-center ml-2 cita">{!! $registro->titulo !!}</span>
                            </td>
                            <td scope="row">
                                <span class="text-center ml-2 cita">{!! $registro->descripcion !!}</span>
                            </td>
                            <td scope="row">
                                <span class="text-center ml-2 cita">{!! $registro->tipo !!}</span>
                            </td>
                            <td scope="row">
                                @if ($registro->pdf != '')
                                    <a title="Enviar Acceso"
                                        href="{{ asset(env('PATH_FILES')) }}/RiteNumero/{{ $registro->pdf }}"
                                        target="_blank">
                                        <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                                    </a>
                                @endif
                            </td>
                            <td scope="row">
                                @if ($registro->miniatura != '')
                                    <img src="{{ asset(env('PATH_FILES')) }}/RiteNumero/{{ $registro->miniatura }}"
                                        alt="" class="miniatura">
                                @endif
                            </td>
                            <td scope="row">
                                @if ($registro->estado == 1)
                                    <span class="text-center ml-2 cita">Activo</span>
                                @else
                                    <span class="text-center ml-2 cita">Inactivo</span>
                                @endif
                            </td>
                            <td scope="row">
                                <a class="badge bg-warning" href="{{ route('editarEstadistica', $registro->id) }}"><i
                                        class="fas fa-edit"></i> Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="row">
            <div class="col-sm-4 text-center"> </div>
            <div class="col-sm-4 text-center">
                @isset($temas)
                    {{ $temas->links('vendor.pagination.custom') }}
                @endisset
            </div>
            <div class="col-sm-4 text-center"> </div>
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

    .descripcion-herramienta,
    .titulo-herramienta {
        width: 400px !important;
    }

    .miniatura {
        width: 80px;
        height: 40px;
    }
</style>
