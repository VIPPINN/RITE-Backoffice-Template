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
          <th scope="col" style="width:200px">Enviado por</th>
          <th scope="col" >Emp. Reportada</th>
          <th scope="col" >Adjunto</th>
          <th scope="col" style="text-align:center;width:200px">Alta</th>
          <th scope="col" style="text-align:center;width:200px">Baja</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>   
        @foreach($notificaciones as $index => $notificacion)
            <th scope="row">
              <span class="text-center ml-2">{{$index+1}}</span>
            </th>

            <td>
              <span class="ml-2">{{$notificacion->asunto}}</span>
            </td>

            <td>
              <span class="ml-2">{{$notificacion->notificacion}}</span>
            </td>
            <td>
              <span class="ml-2">{{$notificacion->apellido}}, {{$notificacion->nombre}}</span>
            </td>
            <td>
              <span class="ml-2">{{$notificacion->CUIT}}</span>
            </td>
            @if($notificacion->adjunto != "")
              <td>
                  <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES')) }}/Notificacion/{{ $notificacion->adjunto }}"   target="_blank">
                      <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                  </a>
              </td>
            @else
            <td>
            <span class="ml-2">Sin Adjunto</span>
              </td>
            @endif
            <td>
              <span class="ml-2">{{$notificacion->fechaAlta}}</span>
            </td>
            <td>
              <span class="ml-2">{{$notificacion->fechaBaja}}</span>
            </td>

       
         
            <td>
              <span class="text-center ml-2">
              <form id="form_usuario" action="" method="POST">

                  
                  <a class="badge bg-info" href=""><i class="fas fa-eye"></i> Ver</a>    
                  @csrf
                  @method('DELETE')
      
                  <button type="button" onclick="javascript:alertDelete('form_usuario')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button> 
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
