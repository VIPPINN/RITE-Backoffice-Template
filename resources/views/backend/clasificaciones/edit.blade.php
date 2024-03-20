@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Registro</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('preguntas.index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
        <form action="{{ route('preguntas.update', $preguntas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="pregunta">Pregunta</label>
                            <textarea id="pregunta" name="pregunta" placeholder="Ingrese el texto...">{{ $preguntas->pregunta }}</textarea>
                            {{ csrf_field() }}
                            @if ($errors->has('pregunta'))
                            <small id="titleError" class="form-text text-danger">{{ $errors->first('pregunta') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="respuestaDisparadorSubpregunta">Disparador SubPregunta</label>
                            <select name="respuestaDisparadorSubpregunta" id="respuestaDisparadorSubpregunta" class="form-control" >
                                @if($preguntas->respuestaDisparadorSubpregunta == "SI")
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option  value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('respuestaDisparadorSubpregunta'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('respuestaDisparadorSubpregunta') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="requiereEvidencia">Evidencia</label>
                            <select name="requiereEvidencia" id="requiereEvidencia" class="form-control" >

                                @if($preguntas->requiereEvidencia == "SI")
                                <option selected value="SI">SI</option>
                                <option value="NO">NO</option>
                                @else
                                <option  value="SI">SI</option>
                                <option selected value="NO">NO</option>
                                @endif

                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('requiereEvidencia'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('requiereEvidencia') }}</small>
                            @endif

                        </div>
                    </div>

                </div>
            </div>


            <div class="container"><br /></div>
            <div class="container">

                <div class="col-sm">
                <div class="form-group">
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="opcionesSugeridas">Opciones/Sugerencias</label>
                                    <textarea id="opcionesSugeridas" name="opcionesSugeridas" placeholder="Ingrese el texto...">{{ $preguntas->opcionesSugeridas }}</textarea>
                                    {{ csrf_field() }}
                                    @if ($errors->has('opcionesSugeridas'))
                                    <small id="titleError" class="form-text text-danger">{{ $errors->first('opcionesSugeridas') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container"><br /></div>
            <div class="container">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idTema">Tema</label>
                            <select name="idTema" id="idTema" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($temas as $index => $tema)

                                    @if($preguntas->idTema == $tema->id)
                                      <option selected value="{{$tema->id}}">{!!$tema->descripcion!!}</option>
                                    @else
                                      <option value="{{$tema->id}}">{!!$tema->descripcion!!}</option>
                                    @endif
                               
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idTema'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idTema') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="opcionesSugeridas">Tipo de Pregunta</label>
                            <select name="idTipoPregunta" id="idTipoPregunta" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($tiposPregunta as $index => $tipoPregunta)

                                    @if($preguntas->idTipoPregunta == $tipoPregunta->id)
                                        <option selected value="{!!$tipoPregunta->id!!}">{!!$tipoPregunta->descripcion!!}</option>
                                    @else
                                        <option value="{!!$tipoPregunta->id!!}">{!!$tipoPregunta->descripcion!!}</option>
                                    @endif

                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idTipoPregunta'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idTipoPregunta') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idCuestionarioVersion">Versiòn Cuestionario</label>
                            <select name="idCuestionarioVersion" id="idCuestionarioVersion" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($versionesCuestionario as $index => $versionCuestionario)
                                    @if($preguntas->idCuestionarioVersion == $versionCuestionario->id)
                                      <option selected value="{!!$versionCuestionario->id!!}">{{$versionCuestionario->idCuestionario}} - {{$versionCuestionario->descripcion}}</option>
                                    @else
                                      <option value="{!!$versionCuestionario->id!!}">{{$versionCuestionario->idCuestionario}} - {{$versionCuestionario->descripcion}}</option>
                                    @endif
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idCuestionarioVersion'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idCuestionarioVersion') }}</small>
                            @endif

                        </div>
                    </div>

                </div>

            </div>

            <div class="container"><br /></div>
            <div class="container">

                <div class="row">
                    

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idPreguntaPadre">Pregunta Padre</label>
                            <select name="idPreguntaPadre" id="idPreguntaPadre" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($preguntas_padres as $index => $pregunta_padre)
                                    @if($preguntas->idPreguntaPadre == $pregunta_padre->id)
                                    <option selected  value="{!!$pregunta_padre->id!!}">{{$pregunta_padre->numero}} - {!!$pregunta_padre->pregunta!!}</option>
                                    @else
                                    <option  value="{!!$pregunta_padre->id!!}">{{$pregunta_padre->numero}} - {!!$pregunta_padre->pregunta!!}</option>
                                    @endif
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idPreguntaPadre'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idPreguntaPadre') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="impactoNivelAvance">Impacto Nivel Avance</label>
                            <select name="impactoNivelAvance" id="impactoNivelAvance" class="form-control" >
                                @if($preguntas->impactoNivelAvance == 1)
                                 <option selected value="1">SI</option>
                                 <option value="0">NO</option>
                                @else
                                 <option  value="1">SI</option>
                                 <option selected value="0">NO</option>
                                @endif

                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('impactoNivelAvance'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('impactoNivelAvance') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4"></div>

                </div>

            </div>

            <div class="container"><br /></div>
            <div class="container">

                <div class="col-sm">
                <div class="form-group">
                    <div class="row">
                        
                            
                            <div class="col-sm-4">
                                <label class="form-check-label" for="numero">Nº de Pregunta&nbsp;</label>
                                <input style="width:100px" value="{{ $preguntas->numero }}" id="numero" name="numero" placeholder="0"><br>
                                @if ($errors->has('numero'))
                                 <small id="linkError" class="form-text text-danger">{{ $errors->first('numero') }}</small>
                                @endif
                                
                            </div>


                            <div class="col-sm-8">
                                <label class="form-check-label" for="cantidadMesesVencimiento">Cantidad de Meses Vencimiento&nbsp;</label>
                                <input style="width:100px" value="{{ $preguntas->cantidadMesesVencimiento }}" id="cantidadMesesVencimiento" name="cantidadMesesVencimiento" placeholder="0"><br>
                                @if ($errors->has('cantidadMesesVencimiento'))
                                 <small id="linkError" class="form-text text-danger">{{ $errors->first('cantidadMesesVencimiento') }}</small>
                                @endif
                                
                            </div>
                        </div> 
                    </div>
                </div>

            </div>


    </div>

    <div class="container"><br /></div>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
    </div>
    </form>
    <script src={{ asset('ckeditor/ckeditor.js') }}></script>
    <script>
            ClassicEditor
            .create(document.querySelector('#pregunta'))
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#opcionesSugeridas'))
            .catch(error => {
                console.error(error);
            }); 

            
            $("#numero").numeric();  $("#cantidadMesesVencimiento").numeric();
    </script>
</div>
</div>

@endsection