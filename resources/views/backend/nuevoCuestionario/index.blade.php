@extends('backend.app')

@section('content')



<div class="container-fluid px-4">
  <h1 class="mt-4">Cuestionario</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de cuestionarios a mostrar en la página</li>
  </ol>
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ URL::to('/backend/cuestionarios/crear')}}" title="Crear Cuestionario"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR UN CUESTIONARIO
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
          <th scope="col">Descripción</th> 
          <th scope="col">Estado Acceso</th>
          <th scope="col">Estado Simulacion</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($cuestionarios as $index => $cuestionario)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
            
            <td>
              <span class="ml-2">{{ $cuestionario->descripcion }}</span>
            </td>

            <td>
            @if ($cuestionario->estadoAoI == 1)
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
            @if ($cuestionario->activoSimulacion == 1)
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
              <form id="form_cuestionario_{{$cuestionario->id}}" action="{{ route('cuestionario-destroy', $cuestionario->id) }}" method="POST">
          
                  <a class="badge bg-warning" href="{{ route('nuevoCuestionario.edit', $cuestionario->id) }}"><i class="fas fa-edit"></i> Editar</a>

                  <a class="badge bg-primary" href="{{ URL::to('/backend/cuestionarios/'.$cuestionario->id)}} "><i class="fas fa-edit"></i> Versiones</a>

                  @csrf
      
                  <!--<button type="submit" class="btn btn-danger">Borrar</button> -->
                  <button type="button" onclick="javascript:alertDelete('form_cuestionario_{{$cuestionario->id}}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                  
                  <!-- <a class="badge bg-primary" href="javascript:void(0)" onclick="alertDelete('{{ $cuestionario->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</a> -->
                
                      
                  <!-- <button type="button" onclick="alertDelete('{{ $cuestionario->id }}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button> -->
               
              </span>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
   
  </div>




</div>

@endsection


<!-- <script> 

function alertDelete(id) {


 swal.fire({

title: "¿Desea borrar al usuario?",

 icon: 'question',

text: "Asegurese antes de confirmar",

 icon: "warning",

 showCancelButton: !0,
 confirmButtonText: "Si, confirmar!",

 cancelButtonText: "No, cancelar!",

 reverseButtons: !0

 }).then(function (e) {

 if (e.value === true) {

 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$.ajax({

 type: 'POST',

 url: "{{url('/backend/cuestionarios/delete')}}/" + id,
 data: {_token: CSRF_TOKEN},

dataType: 'JSON',

success: function (results) {
  

 if (results.success === true) {

swal.fire("Borrado!", results.message, "success");

 // refresh page after 2 seconds

 setTimeout(function(){

 location.reload();

 },2000);

 } else {

 swal.fire("Error!", results.message, "error");

 }

 } });




} else {

e.dismiss;

 }




}, function (dismiss) {

 return false;

})
}
</script> -->
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
    </script>