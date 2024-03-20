@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Redes Sociales</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('empresas.index')}}">Inicio</a></li>
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
            <label for="titleSlider"><strong>Razon Social</strong></label> <br>
            <span>{{ $usuario -> razonSocial }}</span>
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
            <label for="titleSlider"><strong>CUIT</strong></label> <br>
            <span>{{ $usuario -> CUIT }}</span>
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
            <label for="titleSlider"><strong>Email principal</strong></label> <br>
            <span>{{ $usuario -> email }}</span>
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
            <label for="titleSlider"><strong>Email Secundario</strong></label> <br>
            <span>{{ $usuario -> emailSecundario }}</span>
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
            <label> <strong>Provincia</strong></label><br/>
            <span>{{ $usuario -> nombreProvincia }}</span>
          </div>
        </div>
        
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="link"><strong>Nombre de Fantasía</strong></label> <br>
            <span>{{ $usuario -> nombreFantasia }}</span>

          
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          
          <div class="col-sm">
            <div class="form-group">
              <label> <strong>Logo </strong></label> <br>
             
              <img src="{{ asset(env('PATH_FILES')) }}/Usuario/{{$usuario->logo}}" 
                  alt="" 
                  width="100">
              {!!$errors->first('image', '<span class="text-danger">:message</span>')!!}
            </div>
          </div>
        </div>
      </div>
    <div class="container"><br/></div>
   
    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label> <strong>Grupo</strong></label><br/>
            <span>{{ $usuario -> grupo }}</span>
          </div>
        </div>
        
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label> <strong>Categoria</strong></label><br/>
            <span>{{ $usuario -> categoria }}</span>
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
            <span>{{ $usuario -> fechaAlta }}</span>
             
              
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
            <span>{{ $usuario -> fechaBaja }}</span>
             
              
            </div>
          </div>
        </div>
      </div>

    </div>
    
  </div>
</div>

@endsection