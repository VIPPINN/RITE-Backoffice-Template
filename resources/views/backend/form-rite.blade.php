@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Qué es RITE?</h1>
  <ol class="breadcrumb mb-4">
      <!--<li class="breadcrumb-item active">Qué es RITE?</li> -->
  </ol>

  <div class="card mb-4">
      <div class="card-header">
          
         <a class="btn btn-success" href="{{ route('form-rite') }}"><i class="fas fa-plus me-1"></i> Agregar</a>
      </div>
      <div class="card-body">
          <table id="datatablesSimple">
              <thead>
                  <tr style="background-color: #0072bb; color:White;">
                      <th align="center">Información Resumida</th>
                      <th align="center">Información Detallada</th>
                      <th align="center">Estado</th>
                      <th align="center">Acción</th>
                     
                  </tr>
              </thead>
            
              <tbody>

                  @foreach ($informacion as $item)

                    <tr>
                        <td> {{ $item -> info_resumida}}</td>
                        <td> {{ $item -> info_detallada}}</td>
                        <td align="center"> @if ($item -> estado == 1)
                            <span class='badge bg-success' style='color:White;'>
                             Activo
                            </span>
                            @else
                             <span class='badge bg-danger' style='color:White;'>
                                Inactivo
                            </span>
                            @endif 
                        </td>
                        
                        <td align="center"> 

                            <a class="badge bg-warning" href="{{ route('form-rite') }}">  <i class="fas fa-edit me-1"></i> </a>
                            &nbsp;
                            <a class="badge bg-danger" href="{{ route('form-rite') }}">  <i class="fas fa-trash-alt"></i> </a>

                        </td>
                    </tr>

                   @endforeach
              </tbody>
          </table>
      </div>
  </div>
</div>
@endsection