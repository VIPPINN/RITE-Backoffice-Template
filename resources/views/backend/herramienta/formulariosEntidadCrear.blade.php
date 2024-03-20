@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar una Herramienta</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Inicio</a></li>
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
        <form action="{{ route('formularioEntidadGuardar') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="container"><br /></div>
            <div class="container">
                <header>Cuestionario</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="cuestionario" id="tamaño" style="width:300px">
                                <option selected value="">Seleccione...</option>
                                @foreach($cuestionarios as $index => $cuestionario)
                                <option value="{{$cuestionario->id}}">{!!$cuestionario->titulo!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container"><br /></div>
            <div class="container">
                <header>Grupo</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tipo" id="tipo" style="width:300px">
                                <option selected value="">Seleccione...</option>
                                @foreach($entidades as $index => $entidad)
                                <option value="{{$entidad->id}}">{!!$entidad->descripcion!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="container"><br /></div>
            <div class="container">
                <header>Tamaño</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tamaño" id="tamaño" style="width:300px">
                                <option selected value="">Seleccione...</option>
                                @foreach($tamaños as $index => $tamaño)
                                <option value="{{$tamaño->id}}">{!!$tamaño->descripcion!!}</option>
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
                            <label> PDF</label>
                            <input type="file" name="pdf" accept="application/pdf" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                            <small id="linkError" class="form-text text-danger"> {{ $errors->first('file') }}
                                <!--Se ha producido un error al ingresar la fecha.-->
                            </small>
                            <!--{!!$errors->first('file', '<span class="text-danger"> Se ha producido un error al ingresar la imagen.</span>')!!} -->
                        </div>
                    </div>

                    <div class="col-sm"> </div>
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

        ClassicEditor
            .create(document.querySelector('#editor_short'))
            .catch(error => {
                console.error(error);
            });
    </script>
</div>
</div>



@endsection