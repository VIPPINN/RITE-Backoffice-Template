@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Agregar Red Social</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('redes.index')}}">Inicio</a></li>
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
    <form action="{{ route('redes.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <div class="form-group">
              <label for="titleSlider">Nombre</label>
              <input type="text" class="form-control" value="{{ old('nombre') }}" id="nombre" name="nombre" aria-describedby="titleError" placeholder="Ingrese el nombre de la red social">
              @if ($errors->has('nombre'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('nombre') }}</small>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <div class="form-group">
              <label for="link">link</label>
              <input type="text" class="form-control" value="{{ old('link') }}" id="link" name="link" aria-describedby="linkError" placeholder="Ingrese un título">
              @if ($errors->has('link'))
                <small id="linkError" class="form-text text-danger">{{ $errors->first('link') }}</small>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <div class="form-group">
              <label> Imagen/Logo</label>
              <input type="file" name="image_logo" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
              <!--{!!$errors->first('image_logo', '<span class="text-danger">Se ha producido un error al ingresar la imagen</span>')!!} -->
              
              @if ($errors->has('image_logo'))
                <small id="linkError" class="form-text text-danger">{{ $errors->first('image_logo') }}</small>
              @endif
            </div>
          </div>
          <div class="col-sm">
            <div class="form-group">
              <label for="color">&nbsp;</label><br>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="status" name="status">
                <label class="form-check-label" for="status">Activo</label>
              </div>
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