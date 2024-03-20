@extends('backend.app')

@section('content')
@foreach ($recurso as $index => $recurso)
<div class="container-fluid px-4">
    <h1 class="mt-4">Recurso: {{ $recurso->titulo}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('recurso.index')}}">Inicio</a></li>
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
                        <label for="titleSlider"><i><strong>Titulo:</strong></i></label><br>
                        <span>{!! $recurso->titulo !!}</span>
                        <div class="container"><br /></div>
                        <div class="form-group">
                            <label for="text"><i><strong>Descripcion:</strong></i></label>
                            <span>{!! $recurso->descripcion !!}</span>

                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="text"><i><strong>Link de Descarga:</strong></i></label>
                                    <span><br>{!! $recurso->descarga !!}</span>
                                    <div class="container"><br /></div>
                                    <div class="col-sm">

                                        <div class="form-group">
                                            <label for="text"><i><strong>Tipo:</strong></i></label><br>
                                            <span>{!! $recurso->tipoRecursoTitulo !!}</span>


                                        </div>
                                        <div class="container"><br /></div>
                                        <div class="form-group">
                                            <label for="text"><i><strong>Orientado a:</strong></i></label><br>

                                            @foreach ( $orientado as $ind => $value)
                                            @if($recurso->id == $value->recursoId)
                                            <span>{!! $value->orientadoTitulo !!}</span>
                                            @endif

                                            @endforeach
                                            <div class="container"><br /></div>
                                            <div class="form-group">
                                                <label for="text"><i><strong>Origen:</strong></i></label><br>
                                                <span>{!! $recurso->origenRecursoTitulo !!}</span>

                                            </div>

                                            <div class="form-group">
                                                <label for="text"><i><strong>Tema:</strong></i></label><br>
                                                <span>{!! $recurso->temaRecursoTitulo !!}</span>

                                            </div>

                                            <div class="container"><br /></div>

                                        </div>
                                        <div class="form-group">
                                            <label for="text"><i><strong>Estado:</strong></i></label><br>

                                            @if ($recurso->status == '1')
                                            <span class="inline-block rounded-full">
                                                ACTIVO
                                            </span>
                                            @else
                                            <span class="inline-block">
                                                INACTIVO
                                            </span>
                                            @endif


                                            @if ($errors->has('title'))
                                            <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el link.</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

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
</div>
@endforeach
@endsection