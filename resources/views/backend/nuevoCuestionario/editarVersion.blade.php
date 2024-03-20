@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Editar Registro</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ URL::to('/backend/cuestionarios/'. $cuestionarioVersion->idCuestionario )}}">Inicio</a></li>
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
  <form action="{{ URL::to('/backend/cuestionarios/editarVersion')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" value="{{ $cuestionarioVersion->id }}" id="id" name="idCuestionarioVersion" aria-describedby="titleError" placeholder="...">
      <div class="container">
        <div class="row">

          <div class="col-sm-4">
            <div class="form-group">
              <label for="descripcion">Cuestionario</label>
              <select name="idCuestionario" id="idCuestionario" class="form-control" >
                <option value="">Seleccione...</option>
                  @foreach ($Cuestionarios as $index => $Cuestionario)
                    @if($cuestionarioVersion->idCuestionario == $Cuestionario->id)
                       <option selected  value="{!!$Cuestionario->id!!}">{!!$Cuestionario->descripcion!!}</option>
                    @else
                      <option  value="{!!$Cuestionario->id!!}">{!!$Cuestionario->descripcion!!}</option>
                    @endif
                  @endforeach
               </select>
              @if ($errors->has('idCuestionario'))
                <small id="titleError" class="form-text text-danger">{{ $errors->first('idCuestionario') }}</small>
              @endif
            </div>
          </div>

          <div class="col-sm-4">  
               

            <div class="col-sm-6">
              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" value="{{ $cuestionarioVersion->descripcion }}" id="descripcion" name="descripcion" aria-describedby="titleError" placeholder="...">
                @if ($errors->has('descripcion'))
                  <small id="titleError" class="form-text text-danger">{{ $errors->first('descripcion') }}</small>
                @endif
              </div>
            </div>

          </div>

        </div>
        <div class="col-sm">
            <div class="form-group">
              <label for="color">&nbsp;</label><br>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" 
                    <?php echo $cuestionarioVersion->estadoAoI == 1 ? 'checked' : ''; ?>
                    id="estado" name="estado">
                <label class="form-check-label" for="estado">Activo Acceso</label>
              </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group">
              <label for="color">&nbsp;</label><br>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" 
                    <?php echo $cuestionarioVersion->activoSimulacion == 1 ? 'checked' : ''; ?>
                    id="estadoSimulacion" name="estadoSimulacion">
                <label class="form-check-label" for="estado">Activo Simulacion</label>
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