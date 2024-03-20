@extends('backend.app')

@section('content')

<div class="container-fluid px-4">
  <h1 class="mt-4">Noticias/Novedades</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de noticias</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('news.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UNA NOTICIA
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
          <th scope="col">Imagen</th>
          <th scope="col">Fecha</th>
          <th scope="col">Título</th>
          <th scope="col">Texto Resumido</th>
          <th scope="col">Texto Detallado</th>
          <th scope="col">Orden</th>
          <th scope="col" class="text-center ml-2">Status</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($news as $index => $noticia)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
            <td>
              <img src="{{ asset(env('PATH_FILES')) }}/news/thumb-{{$noticia->imagenPublicacion}}" alt="{{ $noticia->titulo }}" width="80">
            </td>
            

            <td>
              <span class="text-center ml-2">{{ date('d-m-Y', strtotime($noticia->fechaPublicacion))}}</span>
            </td>

            
            <td>
              
              @if (strlen($noticia->titulo) >= 50)
               <span>{!! substr($noticia->titulo, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $noticia->titulo !!}</span> 
              @endif

            </td>
            <td class="ml-2 px-6 py-2">

              @if (strlen($noticia->descripcionCorta) >= 50)
               <span>{!! substr($noticia->descripcionCorta, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $noticia->descripcionCorta !!}</span> 
              @endif

            </td>
            <td class="text-center ml-2">

              @if (strlen($noticia->descripcionLarga) >= 50)
               <span>{!! substr($noticia->descripcionLarga, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $noticia->descripcionLarga !!}</span> 
              @endif

            </td>

            <td class="text-center ml-2">
              <span class="text-center ml-2">{{$noticia->orden}}</span>
            </td>
            <td class="text-center ml-2">
              @if ($noticia->estado == 1)
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
                <form id="form_novedades_{{$noticia->id}}" action="{{ route('news.destroy', $noticia->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('news.show', $noticia->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('news.edit', $noticia->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')
      
                  <!--<button type="submit" class="btn btn-danger">Borrar</button> -->
                  <button type="button" onclick="javascript:alertDelete('form_novedades_{{$noticia->id}}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
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
      @isset($news)
        {{ $news->links('vendor.pagination.custom') }}
      @endisset
    </div>
    <div class="col-sm-4 text-center"> </div>
  </div>


</div>

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

    function orderFunction(estado) 
    {
        let pathname = "/backend/news/filtro/" + estado;
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
