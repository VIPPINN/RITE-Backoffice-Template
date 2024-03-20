@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Editar Herramienta</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('empresa') }}">Inicio</a></li>
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
            <form action="{{route('empresaHerramientaUpdate', $herramienta->id)}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="container">
                    <header>titulo</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <textarea class="titulo-textarea" maxlength="255" name="titulo" placeholder="Ingrese el texto...">{{ $herramienta->titulo }}</textarea>
                                {{ csrf_field() }}
                                @if ($errors->has('title'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Descripcion</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <textarea class="descripcion-textarea" name="descripcion" maxlength="255" placeholder="Ingrese el texto...">{{ $herramienta->descripcion }}</textarea>
                                {{ csrf_field() }}
                                @if ($errors->has('title'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container"><br /></div>

                <div class="container">

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">

                                <label> PDF</label>
                                <input type="file" name="pdf" accept="application/pdf"
                                    class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                                @if (!empty($herramienta->pdf))
                                    <a title="Documento Actual"
                                        href="{{ asset(env('PATH_FILES')) }}/Herramienta/{{ $herramienta->pdf }}"
                                        target="_blank">
                                        <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                                    </a>
                                @endif
                                <small id="linkError" class="form-text text-danger"> {{ $errors->first('file') }}
                                    <!--Se ha producido un error al ingresar la fecha.-->
                                </small>

                            </div>
                        </div>

                        <div class="col-sm"> </div>
                    </div>
                </div>



                <div class="container"><br /></div>
                <div class="container">
                    <header>Codigo del Video en Youtube</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="titulo" name="link" placeholder="Ingrese el código del video"
                                    style="width:60%" value="{{ $herramienta->linkVideo }}"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('title'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Tipo</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <select name="tipo" id="tipo" style="width:300px">
                                    <option selected value="">Seleccione...</option>
                                    @foreach ($herramientaTipo as $index => $tipo)
                                        @if ($herramienta->descripcionTipo == $tipo->descripcion)
                                            <option value="{{ $tipo->id }}" selected>{!! $tipo->descripcion !!}</option>
                                        @else
                                            <option value="{{ $tipo->id }}">{!! $tipo->descripcion !!}</option>
                                        @endif
                                    @endforeach
                                </select>
                                {{ csrf_field() }}
                            </div>
                        </div>
                    </div>
                </div>


            <div class="container"><br /></div>
            <div class="container">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="color">&nbsp;</label><br>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="estado" name="estado" {{ $herramienta->activo == 1 ? "checked" : ""}}>
                            <label class="form-check-label" for="estado">Activo</label>
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
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#editor_short'))
                .catch(error => {
                    console.error(error);
                });
        </script>
    </div>
    </div>



@endsection
