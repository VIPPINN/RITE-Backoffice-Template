@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Editar Cita</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/backend/sostenible/') }}">Inicio</a></li>
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
            <form action="{{ URL::to('/backend/sostenible-cuestionarios/update-cuestionarios/' . $cuestionario->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="titleSlider">Titulo</label>
                                <input id="titulo" class="form-control" value="{{ $cuestionario->titulo }}"
                                    name="title" aria-describedby="titleError" placeholder="Ingrese un título"
                                    maxlength="80">
                                @if ($errors->has('title'))
                                    <small id="titleError"
                                        class="form-text text-danger">{{ $errors->first('title') }}</small>
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
                                <label for="titleSlider">Texto</label>
                                <textarea type="text" class="form-control" id="editor" name="texto" aria-describedby="usuarioError"
                                    placeholder="Ingrese texto">{{ $cuestionario->texto }}</textarea>
                                @if ($errors->has('usuario'))
                                    <small id="usuarioError"
                                        class="form-text text-danger">{{ $errors->first('usuario') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">

                    <div class="col-sm">
                        <div class="form-group">
                            <label for="titleSlider">Color (hexadecimal con #)</label>
                            <input id="color" class="form-control" value="{{ $cuestionario->color }}" name="color"
                                aria-describedby="titleError" placeholder="Ingrese un título" maxlength="80">
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
    </div>
    </div>
    <script src={{ asset('ckeditor/ckeditor.js') }}></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
