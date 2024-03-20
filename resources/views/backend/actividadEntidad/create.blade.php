@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Agregar Actividad Entidad</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('actividadEntidad.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Agregar</li>
    </ol>
  </nav>

  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Verifique los errores marcados.<br>
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
    <form action="{{ route('actividadEntidad.store') }}" method="POST">
      @csrf
      
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <input type="text" class="form-control" value="{{ old('descripcion') }}" id="descripcion" name="descripcion" aria-describedby="titleError" placeholder="...">
              @if ($errors->has('descripcion'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('descripcion') }}</small>
              @endif
            </div>
          </div>

          <div class="col-sm-4"> 

            <div class="form-group">
              <label for="orden">Orden</label>
              <input type="text" class="form-control" value="{{ old('orden') }}" id="orden" name="orden" aria-describedby="titleError" placeholder="...">
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
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection