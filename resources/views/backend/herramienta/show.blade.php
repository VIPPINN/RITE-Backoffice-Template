@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Herramienta</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('herramienta.index')}}">Inicio</a></li>
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
            <label for="titleSlider"><strong>titulo</strong></label> <br>
            <span>{{ $herramienta -> titulo }}</span>
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
  <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Descripcion</strong></label> <br>
            <span>{{ $herramienta -> descripcion }}</span>
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>PDF</strong></label> <br>
            @if($herramienta->pdf != "")
                        <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES')) }}/Herramienta/{{ $herramienta->pdf }}"   target="_blank">
                            <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                        </a>
                    @endif
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Excel</strong></label> <br>
            @if($herramienta->excel != "")
                            <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES')) }}/Herramienta/{{ $herramienta->excel }}"   target="_blank"><i class="far fa-file-excel" style="color:green; width:20px;height:20px"></i>
                                </a>
                            @endif
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Video</strong></label> <br>
            <span>{{ $herramienta -> linkVideo }}</span>
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
    <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Estado</strong></label> <br>
            @if($herramienta -> activo == 0)
                <span>Inactivo</span>
            @else
                <span>Activo</span>
           @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Tipo</strong></label> <br>
            <span>{{ $herramienta -> descripcionTipo }}</span>
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Orden</strong></label> <br>
            <span>{{ $herramienta -> orden }}</span>
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
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
            <label for="color"><strong>Alta</strong> &nbsp;</label><br>
            <span>{{ $herramienta -> fechaAlta }}</span>
             
              
            </div>
          </div>
        </div>
      </div>
      <div class="container"><br/></div>
      <div class="container">
      <div class="row">
        
        <div class="col-sm">
          <div class="form-group">
            <label for="color"><strong>Baja</strong> &nbsp;</label><br>
            <span>{{ $herramienta -> fechaBaja }}</span>
             
              
            </div>
          </div>
        </div>
      </div>

    </div>
    
  </div>
</div>

@endsection