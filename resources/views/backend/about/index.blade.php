@extends('backend.app')

@section('content')

<div class="container-fluid px-4">
  <h1 class="mt-4">¿Qué es RITE?</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de Información</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('about.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UN REGISTRO
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
          <th scope="col">Texto corto</th>
          <th scope="col">Texto largo</th>
          <th scope="col">PDF</th>
          <th scope="col">Estado</th>
          <th scope="col" class="text-center ml-2">Acciones</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($about as $index => $about_1)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
           
            <td>

              @if (strlen($about_1->titulo) >= 50)
               <span >{!! substr($about_1->titulo, 0, 50) . "..." !!}</span>  
              @else
               <span >{!! $about_1->titulo !!}</span> 
              @endif

            </td>
            
            <td class="ml-2 px-6 py-2">
              
              @if (strlen($about_1->descripcionCorta) >= 50)
               <span >{!! substr($about_1->descripcionCorta, 0, 50) . "..." !!}</span>
              @else
               <span >{!! $about_1->descripcionCorta !!}</span>
              @endif

            </td>

            <td class="ml-2 px-6 py-2">
              
              @if (strlen($about_1->descripcionLarga) >= 50)
               <span >{!! substr($about_1->descripcionLarga, 0, 50) . "..." !!}</span> 
              @else
               <span >{!! $about_1->descripcionLarga !!}</span>
              @endif

            </td>

            <td class="ml-2">
                <a title="Enviar Acceso" href="{{asset( env('PATH_FILES')."/about/$about_1->enlacePdf" )}}"   target="_blank">
                    @if(file_exists(env('PATH_FILES')."/about/$about_1->enlacePdf")) 
                    <i class="far fa-file-pdf" style="color:red; width:30px;height:30px"></i>
                @else
                    <i class="fas fa-exclamation" style="color:red; width:30px;height:30px"></i>
                @endif
              </a>
            </td>

            
            <td class="ml-2">

              @if ($about_1->estado == 1)
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
                <form id="form_about_{{ $about_1->id }}" action="{{ route('about.destroy', $about_1->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('about.show', $about_1->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('about.edit', $about_1->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')
      
                  <button type="button" onclick="javascript:alertDelete('form_about_{{ $about_1->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
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
      @isset($about)
        {{ $about->links('vendor.pagination.custom') }}
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
        let pathname = "/backend/about/filtro/" + estado;
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