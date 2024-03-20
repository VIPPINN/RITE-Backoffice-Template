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
  <h1 class="mt-4">Notificaciones</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de Notificaciones</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('notificacionEnviada.create') }}" title="Crear Notificacion"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR NOTIFICACION
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
          <th scope="col">Asunto</th>
          <th scope="col" style="width:300px">Notificacion</th>
          
          <th scope="col">Destinatario/s</th>
          <th scope="col">Tipo</th>
          <th scope="col" style="text-align:center;width:200px">Alta</th>
          <th scope="col" style="text-align:center;width:200px">Baja</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
       @foreach($notificaciones as $index => $notificacion)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{$notificacion->id}}</span>
            </th>

            <td>
              <span class="ml-2">{{$notificacion->asunto}}</span>
            </td>

            <td>
              <span class="ml-2">{{$notificacion->notificacion}}</span>
            </td>

            
            <td>
            
            @foreach($destinos as $index2 => $destino)
                @foreach($destino as $ind => $dest)
                    @if($dest->idNotificacion == $notificacion->id)
                        <span class="ml-2">{{$dest->apellido}}, {{$dest->nombre}}</span></br>
                    @endif
                @endforeach 
            @endforeach
            
            </td>
            <td>
              <span class="ml-2">{{$notificacion->descripcion}}</span>
            </td>

            <td>
              <span class="ml-2">{{$notificacion->fechaAlta}}</span>
            </td>

            <td>
              <span class="ml-2">{{$notificacion->fechaBaja}}</span>
            </td>

           
            <td>
              <span class="text-center ml-2">
              <form id="form_usuario{{$notificacion->id}}" action="{{ route('notificacionEnviada.destroy', $notificacion->id) }}" method="POST">

                  
                  <a class="badge bg-info" href="{{ route('notificacionEnviada.show', $notificacion->id) }}"><i class="fas fa-eye"></i> Ver</a> 
    
                  <a class="badge bg-warning" href="{{ route('notificacionEnviada.edit', $notificacion->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')
      
                  <button type="button" onclick="javascript:alertDelete('form_usuario{{$notificacion->id}}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button> 
                </form>
              </span>
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
