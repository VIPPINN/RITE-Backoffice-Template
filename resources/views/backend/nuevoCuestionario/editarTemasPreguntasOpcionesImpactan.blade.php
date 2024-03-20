@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Editar Registro</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ URL::to('/backend/cuestionarios/temas/preguntas/'. $opcion->idPregunta)}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
  </nav>

  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Verifique los errores marcados..<br>
    </div>
  @endif
    
  @if ($message = Session::get('success'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
          {{ $message }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
  @else 
      <div>{{ $message }}</div>
  @endif
  <div class="row">
    <form action="{{ URL::to('/backend/cuestionarios/editarOpcionImpacta') }}" method="POST" enctype="multipart/form-data">
      @csrf    
      <div class="col-sm-4">
            <div class="form-group">
              <label for="descripcion">Pregunta:</label>
              {!!$pregunta->pregunta!!}
                <input type="hidden" name="idPregunta" value="{!!$pregunta->id!!}">
              @if ($errors->has('idPregunta'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('idPregunta') }}</small>
              @endif
            </div>
          </div>
              
      <input type="hidden" value="{{ $opcion->id }}" id="id" name="id" aria-describedby="titleError" placeholder="...">
      @if ($errors->has('id'))
        <small id="titleError" class="form-text text-danger">{{ $errors->first('id') }}</small>
      @endif
          <div class="container"></div><br>

      </div>      
      <div class="container"><br/></div>
     
      <div class="col-sm-6">
            <div class="form-group">
              <label for="descripcion">Opción Impacta: </label>
              <select name="impacta"  class="form-control select-300">
              <option value="{!! $opcion->opcion !!}">{!! $opcion->opcion !!}</option>
            @if ($opcion->opcion== "SI")
            <option value="NO">NO</option>
            <option value="NO APLICA">NO APLICA</option>
            @endif
            @if ($opcion->opcion== "NO APLICA")
            <option value="SI">SI</option>
            <option value="NO">NO</option>
            @endif
            @if ($opcion->opcion== "NO")
            <option value="SI">SI</option>
            <option value="NO APLICA">NO APLICA</option>
            @endif
             
              </select>
              @if ($errors->has('descripcion'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('descripcion') }}</small>
              @endif
            </div>
          </div>
    {{ csrf_field() }}
    @if ($errors->has('impacta'))
    <small id="linkError" class="form-text text-danger">{{ $errors->first('impacta') }}</small>
    @endif

      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection