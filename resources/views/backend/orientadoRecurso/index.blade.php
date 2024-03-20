@extends('backend.app')

@section('content')

<div class="container-fluid px-4">
  <h1 class="mt-4">Orientado Recurso</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de <Table>Orientado Recurso</Table></li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('orientadoRecurso.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UN ORIENTADO DE RECURSO
        </a>
    </div>
  </div>

  @include('backend.filtro')

  @if ($message = Session::get('success'))
     <!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
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
          <th scope="col">Título</th>
          <th scope="col">Descripcion</th>
     
          <th scope="col">Status</th>
          <th scope="col" class="text-center ml-2">Acciones</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($orientadoRecurso as $index => $orientadoRecurso2 )
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
           
            <td>
              <span >{!! $orientadoRecurso2->titulo !!}</span>
            </td>
            <td class="ml-2 px-6 py-2">
              <span >{!! $orientadoRecurso2->descripcion !!}</span>
            </td>
           
            <td class=" ml-2">
              @if ($orientadoRecurso2->estado == '1')
                  <span class="inline-block rounded-full">
                      ACTIVO
                  </span>
              @else
                  <span class="inline-block">
                      INACTIVO
                  </span>
              @endif
            </td>
            
            <td>
              <span class="text-center ml-2">
                <form id="form_orientadoRecurso" action="{{ route('orientadoRecurso.destroy', $orientadoRecurso2->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('orientadoRecurso.show', $orientadoRecurso2->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('orientadoRecurso.edit', $orientadoRecurso2->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')
      
                  <button type="submit" onclick="javascript:alertDelete()" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
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
      @isset($orientadoRecurso)
        {{ $orientadoRecurso->links('vendor.pagination.custom') }}
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

    function alertDelete() {
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
                    $("#form_orientadoRecurso" ).submit();
                } //if
        }); //.them
    } 

    function orderFunction(estado) {
        let pathname = "/backend/orientadoRecurso/filtro/" + estado;
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
