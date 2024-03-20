@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar un Recurso</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('recurso.index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar</li>
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
        <form action="{{ route('recurso.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <header>Título</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="titulo" placeholder="Ingrese Titulo" style="width:60%"></input>
                            {{ csrf_field() }}
                            @if ($errors->has('title'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="container"><br /></div>
            <div class="container">
                <header>Descripción</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">

                            <textarea id="editor" name="editor" placeholder="Ingrese la descripcion..."></textarea>
                            {{ csrf_field() }}
                            @if ($errors->has('title'))
                            <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el texto.</small>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
            <div class="container"><br /></div>
            <div class="container">

                <div class="row">
                    <header>Link de Descarga</header>
                    <div class="col-sm">
                        <div class="form-group">

                            <input type="text" id="descargarLink" name="descargarLink" placeholder="Ingrese el link de descarga...">

                            @if ($errors->has('title'))
                            <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el texto.</small>
                            @endif


                        </div>

                    </div>
                </div>


            </div>

            <!-- Selector de tipo de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Tipo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tipo" id="tipo" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($tipoRecurso as $index => $tipoRecurso)
                                <option value="{!!$tipoRecurso->id!!}">{!!$tipoRecurso->titulo!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selector de orientaddo a de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Orientado a</header>
                    <div class="col-sm">
                        <div class="form-group">

                            @foreach ($orientadoRecurso as $index => $valor)
                            <input type="checkbox" name="orientado{{$index}}" id="orientado{{$index}}" value="{!!$valor->id!!}">
                            <label class="form-check-label" for="status">{!!$valor->titulo!!}</label><br>
                            @endforeach

                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selector de origen de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Origen</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="origen" id="origen" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($origenRecurso as $index => $origenRecurso)
                                <option value="{!!$origenRecurso->id!!}">{!!$origenRecurso->titulo!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selector de tema de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Tema</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tema" id="tema" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($temaRecurso as $index => $temaRecurso)
                                <option value="{!!$temaRecurso->id!!}">{!!$temaRecurso->titulo!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="container"><br /></div>
            <div class="container">

                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">


                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="color">&nbsp;</label><br>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="status" name="status">
                                        <label class="form-check-label" for="status">Activo</label>
                                    </div>
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
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div>
        </form>
        <script src={{ asset('ckeditor/ckeditor.js') }}></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
            
        </script>
    </div>
</div>



@endsection