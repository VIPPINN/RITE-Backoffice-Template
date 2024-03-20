@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Editar Registro</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ URL::to('/backend/cuestionarios/temas/'. $cuestionarioVersion->id)}}">Inicio</a></li>
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
    <form action="{{ URL::to('/backend/cuestionarios/editarTema')}}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="container">
        <div class="row">
          <div class="col-sm-4">  </div>
              <label>Cuestionario Versión: {{$cuestionario->descripcion}} - {{$cuestionarioVersion->descripcion}}</label>
           </div>
      </div>
   
     
      <div class="container">  </div><br>

      <div class="container">
    
    <div class="row">

      <div class="col-sm-6">
        <div class="form-group">
          <input type="hidden" value="{{ $tema->id }}" id="id" name="id" aria-describedby="titleError" placeholder="...">
          @if ($errors->has('id'))
            <small id="titleError" class="form-text text-danger">{{ $errors->first('id') }}</small>
          @endif
        </div>
      </div>
      
      <div class="container">  </div><br>


      <div class="container">
    
        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <input type="text" class="form-control" value="{{ $tema->descripcion }}" id="descripcion" name="descripcion" aria-describedby="titleError" placeholder="...">
              @if ($errors->has('descripcion'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('descripcion') }}</small>
              @endif
            </div>
          </div>

          <div class="col-sm-4">

            <div class="form-group">
              <label for="orden">Orden</label>
              <input type="text" class="form-control" value="{{ $tema->orden }}" id="orden" name="orden" aria-describedby="titleError" placeholder="...">
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