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
        <h1 class="mt-4">Roles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de <Table>Roles</Table>
            </li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('roles.create') }}" title="Create a question">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR UN ROL
                </a>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                        <th scope="col">#</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Permisos</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $index => $rol)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
                            </th>

                            <td>
                                <span>{!! $rol->name !!}</span>
                            </td>
                            <td>
                                @foreach ($rol->permissions as $permission)
                                    <span>{{ $permission->name }}</span></br>
                                @endforeach
                            </td>
                            <td>
                                <span class="text-center ml-2">
                                    <form id="form_rol{{ $rol->id }}" action="{{ route('roles.destroy', $rol->id) }}" method="POST">
                                        <a class="badge bg-warning" href="{{ route('roles.edit', $rol->id) }}"><i class="fas fa-edit"></i> Editar</a>
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="javascript:alertDelete('form_rol{{ $rol->id }}')" class="badge bg-danger"><i
                                                class="fas fa-edit"></i> Borrar</button>
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
