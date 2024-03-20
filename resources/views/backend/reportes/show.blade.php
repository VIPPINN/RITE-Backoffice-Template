@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Reporte Recibido</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('notificacionRecibida.index')}}">Inicio</a></li>
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
  <div class="container"><br/></div>
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><strong>Asunto</strong></label> <br>
            <span>{{$notificacion->asunto}}
            </span>
            @if ($errors->has('name'))
              <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
            @endif
          </div>
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
            <label for="titleSlider"><strong>Notificacion</strong></label> <br>
            <span>{{$notificacion->notificacion}}</span>
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
            <label for="titleSlider"><strong>Enviado Por</strong></label> <br>
            
            <span>{{$emisor->apellido}}, {{$emisor->nombre}}</span></br>
            
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
            <label for="color"><strong>Empresa Reportada</strong> &nbsp;</label><br>
            <label>Razon Social</label>
                <span>
                    {{$reportada->razonSocial}}
                </span>
</br>
            <label>CUIT</label>
            <span>
                    {{$reportada->CUIT}}
                </span>
              
            </div>
          </div>
        </div>
      </div>
      
    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        
        <div class="col-sm">
          <div class="form-group">
            <label for="color"><strong>Adjunto</strong> &nbsp;</label><br>
            @if($notificacion->adjunto != "")
              <td>
                  <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES_UPLOADS')) }}/Notificacion/{{ $notificacion->adjunto }}"   target="_blank">
                      <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                  </a>
              </td>
            @else
            <td>
            <span class="ml-2">Sin Adjunto</span>
              </td>
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
            <span>{{$notificacion->fechaAlta}}</span>
             
              
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
            <span>{{$notificacion->fechaBaja}}</span>
             
              
            </div>
          </div>
        </div>
      </div>

    </div>
    
  </div>
</div>

@endsection