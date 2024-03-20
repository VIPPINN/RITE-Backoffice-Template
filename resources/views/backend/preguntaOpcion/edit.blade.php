@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Editar Registro</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('preguntaOpcion.index')}}">Inicio</a></li>
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
    <form action="{{ route('preguntaOpcion.update', $preguntaOpcion->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="container">
        <div class="row">

          <div class="col-sm-4">  </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label for="descripcion">Grupo</label>
              <select name="idPregunta" id="idPregunta" class="form-control" >
                <option value="">Seleccione...</option>
                  @foreach ($preguntas as $index => $pregunta)
                    @if($preguntaOpcion->idPregunta == $pregunta->id)
                       <option selected  value="{!!$pregunta->id!!}">N° {{$pregunta->numero}} - {!!$pregunta->pregunta!!}</option>
                    @else
                      <option  value="{!!$pregunta->id!!}">N° {{$pregunta->numero}} - {!!$pregunta->pregunta!!}</option>
                    @endif
                  @endforeach
               </select>
              @if ($errors->has('idPregunta'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('idPregunta') }}</small>
              @endif
            </div>
          </div>

          <div class="col-sm-4">  </div>

        </div>
      </div>


      <div class="container">
    
        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <input type="text" class="form-control" value="{{ $preguntaOpcion->descripcion }}" id="descripcion" name="descripcion" aria-describedby="titleError" placeholder="...">
              @if ($errors->has('descripcion'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('descripcion') }}</small>
              @endif
            </div>
          </div>

          <div class="col-sm-4">

            <div class="form-group">
              <label for="orden">Orden</label>
              <input type="text" class="form-control" value="{{ $preguntaOpcion->orden }}" id="orden" name="orden" aria-describedby="titleError" placeholder="...">
              @if ($errors->has('orden'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('orden') }}</small>
              @endif
            </div>

          </div>

        </div>

      </div>
      
      <div class="container"><br/></div>
  
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