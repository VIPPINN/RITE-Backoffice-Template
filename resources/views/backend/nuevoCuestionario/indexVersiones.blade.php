@extends('backend.app')

@section('content')


  <div class="container-fluid px-4">
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-primary" href="{{ URL::to('/backend/cuestionarios/')}}"> 
           Volver
        </a>
    </div>
  </div>
  </div>
<div class="container-fluid px-4">
  <h1 class="mt-4">Cuestionario Versión</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Formulario para la carga de versiones de cuestionario a mostrar en la página</li>
  </ol>
  @if($primeraversioncuestionario == 1)
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ URL::to('/backend/cuestionarios/crearVersion/'. $idCuestionario)}}" title="Crear Versión Cuestionario"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR 1° VERSIÓN CUESTIONARIO
        </a>
    </div>
  </div>
@else
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ URL::to('/backend/cuestionarios/crearVersion/'. $idCuestionario)}}" title="Crear Versión Cuestionario"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR VERSIÓN CUESTIONARIO
        </a>
    </div>
  </div>
@endif
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
          <th scope="col">Fecha de Alta</th>
          <th scope="col">Fecha de Baja</th>
          <th scope="col">Estado Acceso</th>
          <th scope="col">Estado Simulacion</th>
          <th scope="col" class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($cuestionariosVersion as $index => $cuestionarioVersion)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>

            <td>
              {{$cuestionarioVersion -> descripcion}}
 
                @if (strlen($cuestionarioVersion->descripcion) >= 50)
                 <span class="ml-2">{{ $cuestionarioVersion->idCuestionario }} - {!! substr($cuestionarioVersion->descripcion, 0, 50) . "..." !!}</span>  
                @else
                 <span class="ml-2" >{{ $cuestionarioVersion->idCuestionario }} - {{ $cuestionarioVersion->descripcion }}</span> 
                @endif

            </td>
            
            <td>
              <span class="ml-2">{{ $cuestionarioVersion->descripcion }}</span>
            </td>

            <td>
              <span class="text-center ml-2">{{ date('d-m-Y', strtotime($cuestionarioVersion->fechaAlta))}}</span>
            </td>

            <td>
              <span class="text-center ml-2">
                @if($cuestionarioVersion->fechaBaja != NULL )
                  <span >{{ date('d-m-Y', strtotime($cuestionarioVersion->fechaBaja))}}</span> 
                @endif
              </span>
            </td>
            <td>
            @if ($cuestionarioVersion->estadoAoI == 1)
                <span class='badge bg-success' style='color:White;'>
                  Activo
                </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
            </td>
           
            </td>
            <td>
            @if ($cuestionarioVersion->activoSimulacion == 1)
                <span class='badge bg-success' style='color:White;'>
                  Activo
                </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
            </td>
           
            </td>
            <td>
              <span class="text-center ml-2">
                <form id="form_cuestionarioVersion_{{ $cuestionarioVersion->id }}" action="{{ route('version-destroy', $cuestionarioVersion->id) }}" method="POST">
                @csrf
                @if ($cuestionarioVersion->estadoAoI == 0)    
                  <a class="badge bg-warning" href="{{ URL::to('/backend/cuestionarios/editarVersion/'.$cuestionarioVersion->id) }}"><i class="fas fa-edit"></i> Editar</a>
                  <a class="badge bg-primary" href="{{ URL::to('/backend/cuestionarios/temas/'.$cuestionarioVersion->id)}} "><i class="fas fa-edit"></i> Temas</a>
                  <button type="button" class="badge bg-danger" onclick="javascript:alertDelete('form_cuestionarioVersion_{{ $cuestionarioVersion->id }}')"><i class="fas fa-edit"></i> Borrar</button>                   
                @else
                <a  class="badge bg-warning" style="pointer-events: none;" href="{{ URL::to('/backend/cuestionarios/editarVersion/'.$cuestionarioVersion->id) }}" ><i class="fas fa-edit"></i> Editar</a>
                <a class="badge bg-primary" href="{{ URL::to('/backend/cuestionarios/temas/'.$cuestionarioVersion->id)}} "><i class="fas fa-edit"></i> Temas</a>
                <button type="button" style="pointer-events: none;" class="badge bg-danger" onclick="javascript:alertDelete('form_cuestionarioVersion_{{ $cuestionarioVersion->id }}')" ><i class="fas fa-edit"></i> Borrar</button> 
                @endif
                  
                </form>
              </span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
   
  </div>




</div>

@endsection
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