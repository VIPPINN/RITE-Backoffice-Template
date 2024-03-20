@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Preguntas Frecuentes</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('faqs.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Ver</li>
    </ol>
  </nav>

  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Se han producido los siguientes errores.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><i><strong>Pregunta:</strong></i></label>
            <span>{!! $faqs->titulo !!}</span>
            @if ($errors->has('title'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
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
            <label for="text"><i><strong>Respuesta:</strong></i></label>
            <span>{!! $faqs->texto !!}</span>
            
            @if ($errors->has('title'))
              <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el link.</small>
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
            <label for="text"><i><strong>Orden:</strong></i></label><br>
            <span>{{ $faqs->orden }}</span>
            
            @if ($errors->has('title'))
              <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el link.</small>
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
            <label for="text"><i><strong>Estado:</strong></i></label><br>
          

              @if ($faqs->estado == 1)
                  <span class='badge bg-success' style='color:White;'>
                    Activo
                  </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
            
            
            @if ($errors->has('title'))
              <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el link.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
        
      </div>
    </div>
  </div>
</div>

@endsection
