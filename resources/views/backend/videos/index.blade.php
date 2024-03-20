@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Video</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de videos</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('videos.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UN VIDEO
        </a>
    </div>
  </div>

  @include('backend.filtro')

  @if ($message = Session::get('success'))
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
        <tr class="btn-primary" >
          <th scope="col" class="text-center ml-2">#</th>
          <th scope="col">Título</th>
          <th scope="col">Link</th>
          <th scope="col" class="text-center ml-2">Status</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($videos as $index => $video)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
            <td>  

              @if (strlen($video->titulo) >= 50)
               <span>{!! substr($video->titulo, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $video->titulo !!}</span> 
              @endif

            </td>
            <td>

              @if (strlen($video->enlace) >= 50)
               <span>{!! substr($video->enlace, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $video->enlace !!}</span> 
              @endif

              
            </td> 

            <td class="text-center ml-2">
              @if ($video->estado == 1)
                  <span class='badge bg-success' style='color:White;'>
                    Activo
                  </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
            </td>
            <td>
              <span class="text-center ml-2">
                <form id="form_video_{{ $video->id }}" action="{{ route('videos.destroy', $video->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('videos.show', $video->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('videos.edit', $video->id) }}"><i class="fas fa-edit"></i> Editar</a>

   
                  @csrf
                  @method('DELETE')
      
                  <!--<button type="submit" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button> -->
                  <button type="button" onclick="javascript:alertDelete('form_video_{{ $video->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>

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
      @isset($videos)
        {{ $videos->links('vendor.pagination.custom') }}
      @endisset
    </div>
    <div class="col-sm-4 text-center"> </div>
  </div>


</div>

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

    function orderFunction(estado) {
        let pathname = "/backend/videos/filtro/" + estado;
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
