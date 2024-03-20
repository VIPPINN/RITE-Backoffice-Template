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
        <h1 class="mt-4">Citas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de citas en inicio</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('citas.create') }}" title="Create a question">
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
                        <th scope="col">Cita</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($citas as $indexCita => $cita)
                        <tr>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $cita->id }}</span>
                            </th>
                            <th scope="row">
                                <span class="text-center ml-2 cita">{!! $cita->texto !!}</span>
                            </th>
                            <th scope="row">
                                <span class="text-center ml-2">{{ $cita->usuarioCita }}</span>
                            </th>
                            <th scope="row">
                                <img src="{{ asset(env('PATH_FILES') . "/CitasIconos/$cita->icono") }}" width="60">
                            </th>
                            <th scope="row">
                                @if ($cita->estado == 1)
                                    <span class="text-center ml-2">Activa</span>
                                @else
                                    <span class="text-center ml-2">Inactiva</span>
                                @endif
                            </th>
                            <th>
                             
                                <form id="form_citas_{{ $cita->id }}" action="{{ route('citas.destroy', $cita->id) }}" method="POST">
                    
                                  <a class="badge bg-warning" href="{{ route('citas.edit', $cita->id) }}"><i class="fas fa-edit"></i> Editar</a>
                   
                                  @csrf
                                  @method('DELETE')
                      
                                  <button type="button" onclick="javascript:alertDelete('form_citas_{{ $cita->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
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

      .cita{
        word-wrap: break-word;
      }
  </style>
  
