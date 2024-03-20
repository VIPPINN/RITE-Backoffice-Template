@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Preguntas</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('preguntas.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Ver</li>
    </ol>
  </nav>
    
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="titleSlider"><i><strong>Pregunta:</strong></i></label>
            <span>{!! $preguntas->pregunta !!}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Disparador SubPregunta:</strong></i></label>
            <span>{!! $preguntas->respuestaDisparadorSubpregunta !!}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Evidencia:</strong></i></label>
            <span>{!! $preguntas->requiereEvidencia !!}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Opciones/Sugerencias:</strong></i></label>
            <span>{!! $preguntas->opcionesSugeridas !!}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Tema:</strong></i></label>
            <span>{!!$temas->descripcion!!}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Tipo de Pregunta:</strong></i></label>
            <span>{!!$tiposPregunta->descripcion!!}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Versiòn Cuestionario:</strong></i></label>
            <span>{{$versionesCuestionario->descripcion}}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Pregunta Padre:</strong></i></label>
            @if ( empty($preguntas_padres) )
            @else
            <span>{!!$preguntas_padres->id!!} - {!!$preguntas_padres->pregunta!!}</span>
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
            <label for="text"><i><strong>Impacto Nivel ALcance:</strong></i></label>
              @if($preguntas->impactoNivelAvance == 1)
              <span>SI</span>
              @else
              <span>NO</span>
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
            <label for="text"><i><strong>Nº de Pregunta:</strong></i></label>
            <span>{!! $preguntas->numero !!}</span>
          </div>
        </div>
      </div>
    </div>


    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Cantidad de Meses Vencimiento:</strong></i></label>
            <span>{!! $preguntas->cantidadMesesVencimiento !!}</span>
          </div>
        </div>
      </div>
    </div>


    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Fecha de Alta:</strong></i></label>
            <span>{{ date('d-m-Y', strtotime($preguntas->fechaAlta))}}</span>
          </div>
        </div>
      </div>
    </div>


    <div class="container"><br/></div>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <label for="text"><i><strong>Fecha de Baja:</strong></i></label>
              @if($preguntas->fechaBaja != NULL )
                <span >{{ date('d-m-Y', strtotime($preguntas->fechaBaja))}}</span> 
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
