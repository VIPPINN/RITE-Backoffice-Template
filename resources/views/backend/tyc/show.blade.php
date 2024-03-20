@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Términos y condiciones</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('tyc.index')}}">Inicio</a></li>
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
                <label for="titulo"><strong>Título</strong></label> <br>
                <span>{!! $tyc->titulo !!}</span>
                @if ($errors->has('titulo'))
                <small id="tituloError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
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
                    <label for="texto1"><strong>Texto 1</strong></label><br>
                    <span>{!! $tyc->texto1 !!}</span>                   
                    @if ($errors->has('texto1'))
                    <small id="texto1Error" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
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
                  <label for="texto2"><strong>Texto 2</strong></label><br>
                  <span>{!! $tyc->texto2 !!}</span>

                  @if ($errors->has('texto2'))
                  <small id="texto2Error" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
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
                  <label for="texto3"><strong>Texto 3</strong></label><br>
                  <span>{!! $tyc->texto3 !!}</span>

                  @if ($errors->has('texto3'))
                  <small id="texto3Error" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                  @endif
              </div>
          </div>

       
      </div>
    </div>
    <div class="container"><br/></div>
    @if($tycpdfs)
    @foreach($tycpdfs as $index => $pdf)
    <div>
    <a href="{{ asset(env('PATH_FILES')) }}/TyCPDFs/{{ $pdf-> pdfNombre }}"   target="_blank">{{ $pdf -> pdfNombre }}</a>
    </div>   </br>   
    @endforeach
    @else
    <b>No hay pdf para mostrar</b>
    @endif

    <div class="container"><br/></div>
    
    <div class="container">
      <div class="row">
        
        <div class="col-sm">
          <div class="form-group">
            <label for="color"><strong>Estado:</strong> &nbsp;</label><br>
            <div class="form-check">
              @if ($tyc->estado == 1)
                  <span class='badge bg-success' style='color:White;'>
                    Activo
                  </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




@endsection