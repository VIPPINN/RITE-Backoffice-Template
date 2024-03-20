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

        function alertHabilitar(form) {

            Swal.fire({
                title: "¿Estas seguro?",
                text: "Habilitar usuario!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, habilitar!",
            }).then((result) => {
                if (result.value) {
                    //si presiona la tecla ok //ajax
                    $("#" + form).submit();
                } //if
            }); //.them
        }
    </script>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Usuarios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de Usuarios</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('usuarios.create') }}" title="Crear Usuario">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR USUARIO
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
            <form action="{{ route('usuarios.buscar') }}" method="GET">
                @csrf

                <div class="buscador-usuarios">
                    <input type="text" name="buscarUsuario" class="input-buscador"
                        placeholder="Buscar usuario por Nombre/Apellido/CUIT/Email" value="{{ request('buscarUsuario') }}">

                </div>
                <button type="submit" class="buscar-usuario">Buscar</button>
            </form>


            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="text-center ml-2">#</th>

                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">CUIT</th>
                        <th scope="col">Email Principal</th>
                        <th scope="col">Email Secundario</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center ml-2 w-250">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $index => $usuario)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
                            </th>

                            <td>
                                <span class="ml-2">{{ $usuario->nombre }}</span>
                            </td>

                            <td>
                                <span class="ml-2">{{ $usuario->apellido }}</span>
                            </td>

                            <td>
                                <span class="ml-2">{{ $usuario->CUIT }}</span>
                            </td>

                            <td>
                                <span class="ml-2">{{ $usuario->email }}</span>
                            </td>

                            <td>
                                <span class="ml-2">{{ $usuario->emailSecundario ?? '---' }}</span>
                            </td>


                            <td>
                                <span class="ml-2">
                                    @if (!empty($usuario->roles))
                                        @foreach ($usuario->roles as $rol)
                                            <li>{{ $rol }}</li>
                                        @endforeach
                                    @else
                                        <span class="ml-2">Sin rol</span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if ($usuario->fechaBaja == null)
                                    <span class="ml-2">Activo</span>
                                @else
                                    <span class="ml-2">Inactivo</span>
                                @endif

                            </td>

                            <td>
                                <span class="text-center ml-2 flex-span">



                                    <a class="badge bg-info" href="{{ route('usuarios.show', $usuario->id) }}"><i
                                            class="fas fa-eye"></i> Ver</a>

                                    <a class="badge bg-warning" href="{{ route('usuarios.edit', $usuario->id) }}"><i
                                            class="fas fa-edit"></i> Editar</a>
                                    @if ($usuario->fechaBaja == null)
                                        <form id="form_usuario{{ $usuario->id }}"
                                            action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button"
                                                onclick="javascript:alertDelete('form_usuario{{ $usuario->id }}')"
                                                class="badge bg-danger delete-button-padding"><i class="fas fa-edit"></i> Borrar</button>
                                        @else
                                            <form id="form_usuario{{ $usuario->id }}"
                                                action="{{ route('usuarios.habilitar', ['id' => $usuario->id]) }}" method="POST">
                                                @csrf
                                                <button type="button"
                                                    onclick="javascript:alertHabilitar('form_usuario{{ $usuario->id }}')"
                                                    class="badge bg-success delete-button-padding"><i class="fas fa-edit"></i> Habilitar</button>
                                    @endif
                                    </form>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{--   <div class="row">
            <div class="col-sm-4 text-center"> </div>
            <div class="col-sm-4 text-center">
                @isset($usuarios)
                    {{ $usuarios->links('vendor.pagination.custom') }}
                @endisset
            </div>
            <div class="col-sm-4 text-center"> </div>
        </div> --}}


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
