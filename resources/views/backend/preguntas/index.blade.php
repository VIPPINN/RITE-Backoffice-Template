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
  <h1 class="mt-4">Preguntas</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de Preguntas</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('preguntas.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UNA PREGUNTA
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
          <th scope="col" class="text-center">Tipo Pregunta</th>
          <th scope="col" class="text-center">Tema</th>
          <th scope="col" class="text-center">Versiòn Cuestionario</th>
          <th scope="col" class="text-center">Fecha Alta</th>
          <th scope="col" class="text-center">Fecha Baja</th>
          <th scope="col" class="text-center">Acciones</th>

        </tr>
      </thead>
      <tbody>

      @foreach ($preguntas as $index => $pregunta) 
     
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>

            <td class="text-center ml-2">
              <span  >{{$pregunta->numero }}</span> 
            </td>
           
            <td class="ml-2 px-6 py-2">

              @if (strlen($pregunta->pregunta) >= 50)
               <span >{!! substr($pregunta->pregunta, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $pregunta->pregunta !!}</span> 
              @endif

            </td>

            <td class="ml-2 px-6 py-2">
              <span >{{$pregunta->idTipoPregunta }} - {{$pregunta-> descripcionTipoPregunta }}</span> 
            </td>

            <td class="ml-2 px-6 py-2">
              <span >{{$pregunta->idTema }} - {{$pregunta->descripcionTema }}</span> 
            </td>
           
            <td class="ml-2 px-6 py-2">
              <span >{{$pregunta->idCuestionario }} - {{$pregunta->descripcionCuestionario }}</span> 
            </td>

            <td class="ml-2 px-6 py-2">
             
              <span >{{ date('d-m-Y', strtotime($pregunta->fechaAlta))}}</span> 
            </td>

            <td class="ml-2 px-6 py-2">
              @if($pregunta->fechaBaja != NULL )
               <span >{{ date('d-m-Y', strtotime($pregunta->fechaBaja))}}</span> 
              @endif
            </td>

            <td>
              <span class="text-center ml-2">
                <form id="form_preguntas_{{ $pregunta->id }}" action="{{ route('preguntas.destroy', $pregunta->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('preguntas.show', $pregunta->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('preguntas.edit', $pregunta->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')

                  @if($pregunta->fechaBaja == NULL )
                    <button type="button" onclick="javascript:alertDelete('form_preguntas_{{ $pregunta->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                  @endif
      
                  
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
      @isset($preguntas)
        {{ $preguntas->links('vendor.pagination.custom') }}
      @endisset
    </div>
    <div class="col-sm-4 text-center"> </div>
  </div>

</div>
<script src={{ asset('ckeditor/ckeditor.js') }}></script>
<script>
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
</script>
@endsection