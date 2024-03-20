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
        <h1 class="mt-4">Relaciones</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de Relaciones entre Usuarios y Empresas</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('delegar.create') }}" title="Agregar relacion">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR RELACION
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
        <div class="row" style="position: relative">
            <form action="{{ route('delegar.buscar') }}" method="GET">
                @csrf

                <div class="buscador-usuarios">
                    <input type="text" name="buscarEmpresa" class="input-buscador"
                        placeholder="Buscar delegacion por Razon Social " value="{{ request('buscarEmpresa') }}">

                </div>
                <button type="submit" class="buscar-usuario">Buscar Empresa</button>
            </form>
            <form action="{{ route('delegar.buscar') }}" method="GET">
                @csrf

                <div class="buscador-usuarios">
                    <input type="text" name="buscarUsuario" class="input-buscador2"
                        placeholder="Buscar delegacion por Nombre o Apellido " value="{{ request('buscarUsuario') }}">

                </div>
                <button type="submit" class="buscar-usuario2">Buscar Usuario</button>
            </form>
            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="text-center ml-2">#</th>

                        <th scope="col">Usuario</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($relaciones as $index => $relacion)
                        <td class="numero text-center">{{ $index + 1 }}</td>
                        <td class="usuario">{!! $relacion->nombre !!}, {!! $relacion->apellido !!}</td>
                        <td class="empresa">{{ $relacion->razonSocial }}</td>
                        @if ($relacion->fechaBaja == null)
                            <td class="empresa">Activa</td>
                        @else
                            <td class="empresa">Inactiva</td>
                        @endif

                        <td>
                            <span class="text-center ml-2">
                                <form id="form_delegar{{ $relacion->id }}"
                                    action="{{ route('delegar.destroy', $relacion->id) }}" method="POST">






                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        onclick="javascript:alertDelete('form_delegar{{ $relacion->id }}')"
                                        class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                                </form>
                            </span>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{--     <div class="row">
            <div class="col-sm-4 text-center"> </div>
            <div class="col-sm-4 text-center">
                @isset($relaciones)
                    {{ $relaciones->links('vendor.pagination.custom') }}
                @endisset
            </div>
            <div class="col-sm-4 text-center"> </div>
        </div> --}}


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

    .buscar-usuario2 {
        position: absolute;
        top: -95px;
        right: 230px;
        height: 38px;
        border-radius: 5px;
        background-color: rgb(13, 110, 253);
        border: none;
        color: white;
        width: 150px;
    }

    .buscar-usuario2:hover {
        border: 1px solid rgb(13, 110, 253);
        color: rgb(13, 110, 253);
        background-color: white;
    }
</style>
