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
  <h1 class="mt-4">Temas</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de Temas</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('tema.create') }}" title="Crear Tipo Entidad"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR TEMA
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
          <th scope="col">Cuestionario</th>
          <th scope="col">Descripción</th>
          <th scope="col">Orden</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($temas as $index => $tema)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>

            <td>
              <span class="ml-2">{{ $tema->idCuestionarioVersion }} - {{ $tema->descripcionCuestionarioVersion }}</span>
            </td>
            
            <td>
              <span class="ml-2">{{ $tema->descripcion }}</span>
            </td>

            <td>
              <span class="text-center ml-2">{{ $tema->orden }}</span>
            </td>

           
            <td>
              <span class="text-center ml-2">
                <form id="form_tema_{{ $tema->id }}" action="{{ route('tema.destroy', $tema->id) }}" method="POST">
     
                  <!--<a class="badge bg-info" href="{{ route('tema.show', $tema->id) }}"><i class="fas fa-eye"></i> Ver</a> -->
    
                  <a class="badge bg-warning" href="{{ route('tema.edit', $tema->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')
      
                  <!--<button type="button" onclick="javascript:alertDelete('form_tema_{{ $tema->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button> -->
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
