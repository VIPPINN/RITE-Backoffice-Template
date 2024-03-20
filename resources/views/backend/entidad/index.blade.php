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
                    $("#" + form).submit();
                } //if
            }); //.them
        }
    </script>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Rango de Ventas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Rango de ventas para clasificacion de Entidades</li>
        </ol>
        <div class="row mt-3 mb-3">
            <div class="col-sm-4 text-right">
                <a class="btn btn-success" href="{{ route('rangos.edit', 1) }}" title="Crear Usuario">
                    <i class="fas fa-plus-circle"></i>
                    ACTUALIZAR VALOR
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
                
                <th scope="col">Categoria</th>
                <th scope="col">Valor Inicial</th>
                <th scope="col">Vlor Final</th>
         
              </tr>
            </thead>
            <tbody>
              @foreach ($rangos as $rango)
              <tr>
                  <td>
                      <span class="ml-2">{{ $rango['tamanio'] }}</span>
                  </td>
                  <td>
                      <span class="ml-2">{{ $rango['limiteVentaTotalAnualInicial'] }}</span>
                  </td>
                  <td>
                      <span class="ml-2">{{ $rango['limiteVentaTotalAnualFinal'] ?? '---' }}</span>
                  </td>
              </tr>
          @endforeach
            </tbody>
          </table>
             
        </div>

     


    </div>
@endsection
