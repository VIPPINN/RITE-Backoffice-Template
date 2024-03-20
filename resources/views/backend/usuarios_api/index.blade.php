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
        <h1 class="mt-4">Usuarios API</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de Usuarios API</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('usuarios_api.create') }}" title="Crear Usuario">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR USUARIO
                </a>
                <a class="btn btn-success" href="{{ route('usuarios_api.giveAccess') }}" title="Crear Usuario">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR ACCESO
                </a>
            </div>
        </div>

        {{--      @include('backend.filtro') --}}

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
            {{--    <form action="" method="GET">
                @csrf

                <div class="buscador-usuarios">
                    <input type="text" name="buscarUsuario" class="input-buscador"
                        placeholder="Buscar usuario por Nombre/Apellido/CUIT/Email" value="">

                </div>
                <button type="submit" class="buscar-usuario">Buscar</button>
            </form> --}}


            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="text-center ml-2">#</th>

                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">CUIT</th>
                        <th scope="col">Email Principal</th>
                        <th scope="col">Client_id</th>
                        <th scope="col">Client_secret</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $indexUsuario => $usuario)
                        <tr>
                            <th> {{ $indexUsuario + 1 }} </th>
                            <th> {{ $usuario->nombre }} </th>
                            <th> {{ $usuario->apellido }} </th>
                            <th scope="col">{{ $usuario->CUIT }}</th>
                            <th scope="col">{{ $usuario->email }}</th>
                            <th scope="col">{{ $usuario->client_id }}</th>
                            <th scope="col">{{ $usuario->client_secret }}</th>
                            <th scope="col">
                                @if ($usuario->API_Activo == 1)
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </th>
                            <th>
                                @if ($usuario->API_Activo == 1)
                                    <form action="{{ route('usuarios_api.revoke', ['id' => $usuario->id]) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Desactivar</button>
                                    </form>
                                @else
                                    <form action="{{ route('usuarios_api.activate', ['id' => $usuario->id]) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Activar</button>
                                    </form>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
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
        function orderFunction(estado) {
            let pathname = "/backend/usuarios/filtro/" + estado;
            window.location.href = pathname;
            switch (estado) {
                case 1:
                    $("#rbActivo").prop("checked", true);
                    break;
                case 0:
                    $("#rbInactivo").prop("checked", true);
                    break;
                case 9:
                    $("#rbTodos").prop("checked", true);
                    break;
                default:
                    break;
            }

        }
    </script>
@endsection
