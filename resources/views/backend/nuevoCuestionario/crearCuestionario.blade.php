@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Agregar Cuestionario</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ URL::to('/backend/cuestionarios/')}}">Inicio</a></li>
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
    <form action="{{ URL::to('/backend/cuestionarios/guardar')}}" method="POST">
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
        </div>
      </div>
      <div class="container"><br/></div>
      <div class="container">      
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="color">&nbsp;</label><br>
                    <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoAoI">
                    <label class="form-check-label" for="estado">Activo</label>
                    </div>
                </div>
            </div>
            </div> 
     
      <div class="container"><br/></div>
      <div class="container">      
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="color">&nbsp;</label><br>
                    <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoTyC">
                    <label class="form-check-label" for="estado">Con Términos y Condiciones</label>
                    </div>
                </div>
           </div>
      </div>
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