@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Editar Registro</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:history.back()">Inicio</a></li>
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
    <form action="{{ route('nuevoCuestionario.update', $cuestionario->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="container">
    
        <div class="row">

          <div class="col-sm-6">
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <input type="text" class="form-control" value="{{ $cuestionario->descripcion }}" id="descripcion" name="descripcion" aria-describedby="titleError" placeholder="...">
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
                      @if( $cuestionario -> estadoAoI == 1)
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoAoI" checked> 
                    @else
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoAoI" > 
                    @endif
                    <label class="form-check-label" for="estado">Activo Acceso</label>
                    </div>
                </div>
            </div>
      </div> 

      <div class="container">      
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="color">&nbsp;</label><br>
                    <div class="form-check">
                      @if( $cuestionario -> activoSimulacion == 1)
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoSimulacion" checked> 
                    @else
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoSimulacion" > 
                    @endif
                    <label class="form-check-label" for="estado">Activo Simulacion</label>
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
                    @if( $cuestionario -> estadoTyC== 1)
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoTyC" checked> 
                    @else
                    <input type="checkbox" class="form-check-input" id="estado" name="estadoTyC" >
                    @endif
                   
                    <label class="form-check-label" for="estado">Con Términos y Condiciones</label>
                    </div>
                </div>
           </div>
      </div>
      
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