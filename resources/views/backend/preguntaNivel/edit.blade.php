@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Registro</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('preguntaNivel.index')}}">Inicio</a></li>
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
        <form action="{{ route('preguntaNivel.update', $preguntaNivel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idPregunta">Pregunta</label>
                            <select name="idPregunta" id="idPregunta" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($preguntas as $index => $pregunta)
                                   
                                    @if($pregunta->id == $preguntaNivel->idPregunta )
                                      <option selected value="{!!$pregunta->id!!}">N° {{$pregunta->numero}} - {!!$pregunta->pregunta!!}</option>
                                    @else
                                      <option value="{!!$pregunta->id!!}">N° {{$pregunta->numero}} - {!!$pregunta->pregunta!!}</option>
                                    @endif
                    
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idPregunta'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idPregunta') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idGrupoEntidad"> Grupo Entidad</label>
                            <select name="idGrupoEntidad" id="idGrupoEntidad" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($gruposEntidad as $index => $grupoEntidad)

                                    @if($grupoEntidad->id == old('idGrupoEntidad') or $grupoEntidad->id == $preguntaNivel->idGrupoEntidad)
                                    <option selected value="{!!$grupoEntidad->id!!}">{!!$grupoEntidad->descripcion!!}</option>
                                    @else
                                    <option value="{!!$grupoEntidad->id!!}">{!!$grupoEntidad->descripcion!!}</option>
                                    @endif

                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idGrupoEntidad'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idGrupoEntidad') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idCategoriaEntidad"> Categoría Entidad</label>
                            <select name="idCategoriaEntidad" id="idCategoriaEntidad" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($categoriasEntidad as $index => $categoriaEntidad)
                                    
                                    @if($categoriaEntidad->id == old('idCategoriaEntidad')  or $categoriaEntidad->id == $preguntaNivel->idCategoriaEntidad)
                                      <option selected value="{!!$categoriaEntidad->id!!}">{{$categoriaEntidad->id}} - {{$categoriaEntidad->descripcion}}</option>
                                    @else
                                      <option value="{!!$categoriaEntidad->id!!}">{{$categoriaEntidad->id}} - {{$categoriaEntidad->descripcion}}</option>
                                    @endif
                                  
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idCategoriaEntidad'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idCategoriaEntidad') }}</small>
                            @endif

                        </div>
                    </div>

                </div>

            </div>

            <div class="container"><br /></div>
            <div class="container">

                <div class="row">
                    
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="idNivel">Nivel </label>
                            <select name="idNivel" id="idNivel" class="form-control" >
                                <option value="">Seleccione...</option>
                                @foreach ($niveles as $index => $nivel)
                                  
                                    @if($nivel->id == old('idNivel') or $nivel->id == $preguntaNivel->idNivel)
                                      <option selected  value="{!!$nivel->id!!}">{{$nivel->id}} - {!!$nivel->descripcion!!}</option>
                                    @else
                                      <option  value="{!!$nivel->id!!}">{{$nivel->id}} - {!!$nivel->descripcion!!}</option>
                                    @endif
                                 
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                            @if ($errors->has('idNivel'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('idNivel') }}</small>
                            @endif

                        </div>
                    </div>

                    <div class="col-sm-4"> </div>

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