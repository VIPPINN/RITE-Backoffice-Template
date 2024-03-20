@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Actividad</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Aquí se listan las actividades recientes</li>
  </ol>
  
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="text-center ml-2">#</th>
          <th scope="col" class="text-center ml-2">Fecha</th>
          <th scope="col" class="text-center ml-2">Actividad</th>
          <th scope="col">URL</th>
          <th scope="col" class="text-center ml-2">Método</th>
          <th scope="col" class="text-center ml-2">IP</th>
          <th scope="col" class="text-center ml-2">Dispositivo</th>
          <th scope="col" class="text-center ml-2">Usuario</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($logs as $index => $log)
          <tr>
            <th scope="row">
              <span class="text-center ml-2">{{ $loop->index + 1 }}</span>
            </th>
            <td>
                <span class="text-center ml-2">{{ date('d-M-Y', strtotime($log->fechaAlta)) }}</span>
            </td>
            <td>
              <span class="text-center ml-2">{{ $log->titulo }}</span>
            </td>
            <td>
              <span class="text-center ml-2">{{ $log->url }}</span>
            </td>
            <td>
              <span class="text-center ml-2">{{ $log->metodo }}</span>
            </td>
            <td class="ml-2 px-6 py-2">
              <span class="text-center ml-2">{{ $log->ip }}</span>
            </td>
            <td class="text-center ml-2">
              <span class="text-center ml-2">{{ $log->agente }}</span>
            </td>
            <td class="text-center ml-2">
              <span class="text-center ml-2">{{ $log->email }}</span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-sm-4 text-center"> </div>
    <div class="col-sm-4 text-center">
      @isset($logs)
        {{ $logs->links('vendor.pagination.custom') }}
      @endisset
    </div>
    <div class="col-sm-4 text-center"> </div>
  </div>
</div>

@endsection
