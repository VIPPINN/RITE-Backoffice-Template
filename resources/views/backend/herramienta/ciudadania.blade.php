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
        <h1 class="mt-4">Herramientas de Ciudadanía</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Formulario para la carga de Herramientas</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('ciudadaniaCrear') }}" title="Crear Herramienta">
                    <i class="fas fa-plus-circle"></i>
                    AGREGAR HERRAMIENTA
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
{{--             <form action="{{ route('ciudadania') }}" method="GET">
                @csrf

                <div class="buscador-usuarios">
                    <input type="text" name="buscarHerramienta" class="input-buscador"
                        placeholder="Buscar herramienta por titulo, descripcion o tipo"
                        value="{{ request('buscarHerramienta') }}">

                </div>
                <button type="submit" class="buscar-usuario">Buscar</button>
            </form> --}}
            <table class="table">
                <thead>
                    <tr class="btn-primary">
                        <th scope="col" class="text-center ml-2">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Video</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-center ml-2">Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($herramientas as $indexHerramienta => $herramienta)
                    <tr>
                        <td scope="row">
                            <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
                        </td>

                        <td class="titulo-herramienta">
                            <span class="ml-2">{!! $herramienta->titulo !!}</span>
                        </td>
                        <td class="descripcion-herramienta">
                            <span class="ml-2">{!! $herramienta->descripcion !!}</span>
                        </td>

                        <td>
                            <span class="ml-2">{{ $herramienta->descripcionTipo }}</span>
                        </td>
                        <td>
                            @if(!empty($herramienta->linkVideo))
                            <span class="ml-2">{{ $herramienta->linkVideo }}</span>
                            @else
                            <span class="ml-2">---</span>
                            @endif
                        </td>
                        <td>
                            @if ($herramienta->activo == 0)
                                <span class="ml-2">Inactivo</span>
                            @else
                                <span class="ml-2">Activo</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-center ml-2">
                                <form id="form_cuestionario_{{ $herramienta->id }}" action="{{ route('ciudadaniaBorrar', $herramienta->id) }}" method="POST">
                        
                                <a class="badge bg-warning" href="{{ route('ciudadaniaEditar', $herramienta->id) }}"><i class="fas fa-edit"></i> Editar</a>
              
                               
              
                                @csrf
                    
                                <button type="button" onclick="javascript:alertDelete('form_cuestionario_{{$herramienta->id}}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                                
                            
                             
                            </span>
                            </form>
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

    .descripcion-herramienta,
    .titulo-herramienta {
        width: 400px !important;
    }
</style>

<script> 

    function alertDelete(form) 
    {
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
                $("#"+ form ).submit();
            } //if
        }); //.them
    }
    </script>
