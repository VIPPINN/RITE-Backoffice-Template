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
        $("#"+ form ).submit();
      } //if
    }); //.them
  } 
  
  </script>
  <div class="container-fluid px-4">
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-primary" href="{{ URL::to('/backend/cuestionarios/temas/preguntas/'.$idTema)}}"> 
            Volver
        </a>
    </div>
  </div>
  </div>

<div class="container-fluid px-4">
  <h1 class="mt-4">Opciones</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la visualizacion y carga de Opciones</li>
  </ol>
  @if($cuestionarioVersionEstado == 0 )
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ URL::to('/backend/cuestionarios/crearOpcion/'. $idPregunta)}}" title="Crear Tipo Entidad"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR OPCIÓN
        </a>
    </div>
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
          <th scope="col" class="text-left ml-2">#</th>
          <th scope="col">Opción</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($opciones as $index => $opcion)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>

            <td>
              <span class="ml-2">{{ $opcion->descripcion }}</span>
            </td>
            
           
           
            <td>
              <span class="text-center ml-2">
                <form id="form_opcion_{{ $opcion->id }}" action="{{ route('opcion-destroy', $opcion->id) }}" method="POST">
       
                @if($cuestionarioVersionEstado == 0 )
                  <a class="badge bg-warning" href="{{ URL::to('/backend/cuestionarios/editarOpcion/'.$opcion->id )}}"><i class="fas fa-edit"></i> Editar</a>

                  @csrf
      
                  <button type="button" onclick="javascript:alertDelete('form_opcion_{{$opcion->id}}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                  @endif
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
