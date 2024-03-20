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
  <h1 class="mt-4">Pregunta Nivel</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de registros</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('preguntaNivel.create') }}" title="Crear registro"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR REGISTRO
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
          <th scope="col">#</th>
          <th scope="col" class="text-center">Nº Pregunta</th>
          <th scope="col" class="text-center">Pregunta</th>
          <th scope="col" class="text-center">Tipo de Pregunta</th>
          <th scope="col" class="text-center">Grupo Entidad</th>
          <th scope="col" class="text-center">Categoría Entidad</th>
          <th scope="col" class="text-center">Nivel</th>
          <th scope="col" class="text-center">Acciones</th>

        </tr>
      </thead>
      <tbody>

      @foreach ($preguntasNivel as $index => $preguntaNivel) 
     
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>

            <td class="text-center ml-2">
              <span  >{{$preguntaNivel->numero }}</span> 
            </td>
           
            <td class="ml-2 px-6 py-2">

              @if (strlen($preguntaNivel->pregunta) >= 50)
               <span >{!! substr($preguntaNivel->pregunta, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $preguntaNivel->pregunta !!}</span> 
              @endif

            </td>

            <td class="ml-2 px-6 py-2">
              <span >{{$preguntaNivel->idTipoPregunta }} - {{$preguntaNivel-> descripcionTipoPregunta }}</span> 
            </td>

            <td class="ml-2 px-6 py-2">
              <span >{{$preguntaNivel->idGrupoEntidad }} - {{$preguntaNivel->descripcionGrupoEntidad }}</span> 
            </td>
           
            <td class="ml-2 px-6 py-2">
              <span >{{$preguntaNivel->idCategoriaEntidad }} - {{$preguntaNivel->descripcionCategoriaEntidad }}</span> 
            </td>

            <td class="ml-2 px-6 py-2">
              <span >{{$preguntaNivel->idNivel }} - {{$preguntaNivel->descripcionNivel }}</span> 
            </td>

            <td>
              <span class="text-center ml-2">
                <form id="form_preguntaNivel_{{ $preguntaNivel->id }}" action="{{ route('preguntaNivel.destroy', $preguntaNivel->id) }}" method="POST">
     
                  <!--<a class="badge bg-info" href="{{ route('preguntaNivel.show', $preguntaNivel->id) }}"><i class="fas fa-eye"></i> Ver</a> -->
    
                  <a class="badge bg-warning" href="{{ route('preguntaNivel.edit', $preguntaNivel->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')

                    <!-- <button type="button" onclick="javascript:alertDelete('form_preguntaNivel_{{ $preguntaNivel->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button> -->
                  
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
      @isset($preguntasNivel)
        {{ $preguntasNivel->links('vendor.pagination.custom') }}
      @endisset
    </div>
    <div class="col-sm-4 text-center"> </div>
  </div>

</div>
<script src={{ asset('ckeditor/ckeditor.js') }}></script>
<!--<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
        ClassicEditor
        .create(document.querySelector('#titulo'))
        .catch(error => {
            console.error(error);
        });
</script> -->
@endsection