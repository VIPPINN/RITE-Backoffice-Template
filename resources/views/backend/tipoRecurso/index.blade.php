@extends('backend.app')

@section('content')



<div class="container-fluid px-4">
  <h1 class="mt-4">Tipo de Recurso</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de <Table>Tipo de Recurso</Table></li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('tipoRecurso.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UN TIPO DE RECURSO
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
        @foreach ($tipoRecurso as $index => $tipoRecurso2 )
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
           
            <td>
              <span >{!! $tipoRecurso2 ->titulo !!}</span>
            </td>
            <td class="ml-2 px-6 py-2">
              <span >{!! $tipoRecurso2->descripcion !!}</span>
            </td>
           
            <td class=" ml-2">
              @if ($tipoRecurso2->estado == '1')
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
                <form id="form_tipoRecurso" action="{{ route('tipoRecurso.destroy', $tipoRecurso2->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('tipoRecurso.show', $tipoRecurso2->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('tipoRecurso.edit', $tipoRecurso2->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
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
      @isset($tipoRecurso)
        {{ $tipoRecurso->links('vendor.pagination.custom') }}
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
                $("#form_tipoRecurso" ).submit();
            } //if
        }); //.them
    }

    function orderFunction(estado) {
        let pathname = "/backend/tipoRecurso/filtro/" + estado;
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
