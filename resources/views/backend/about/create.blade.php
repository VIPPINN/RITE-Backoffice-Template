@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar Registro</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('about.index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar</li>
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
        <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            {{-- <textarea id="titulo" name="titulo" placeholder="Ingrese Titulo">{{ old('titulo') }}</textarea> --}}
                            <input id="titulo" name="titulo" type="text"
                                    placeholder="Ingrese Titulo" 
                                    value="{{ old('titulo') }}"
                                    class="form-control">
                            {{ csrf_field() }}
                            @if ($errors->has('titulo'))
                            <small id="titleError" class="form-text text-danger"> {{ $errors->first('titulo') }}</small>
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
                            <label for="editor_short">Texto Resumido</label>
                            <textarea id="editor_short" name="editor_short" placeholder="Ingrese el texto corto...">{{ old('editor_short') }}</textarea>
                            {{ csrf_field() }}
                            @if ($errors->has('editor_short'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('editor_short') }}</small>
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
                            <label for="editor_large">Texto Detallado</label>
                            <textarea id="editor_large" name="editor_large" placeholder="Ingrese el texto largo...">{{ old('editor_large') }}</textarea>
                            {{ csrf_field() }}
                            @if ($errors->has('editor_large'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('editor_large') }}</small>
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
                          <input type="file" name="file" accept="application/pdf" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                          <small id="linkError" class="form-text text-danger"> {{ $errors->first('file') }} <!--Se ha producido un error al ingresar la fecha.--> </small>
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
                                <div class="form-group">
                                    <label for="color">&nbsp;</label>
                                    <div class="form-check">
                                        <label class="form-check-label" for="status">Activo</label>
                                        <input type="checkbox" class="form-check-input" @if(old('status') == 'on') checked  @endif   id="status" name="status"><br>
                                        @if ($errors->has('status'))
                                        <small id="titleError" class="form-text text-danger"> {{ $errors->first('status') }}</small>
                                        @endif
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
                .create(document.querySelector('#editor_large'))
                .catch(error => {
                    console.error(error);
                });
            // ClassicEditor
            //     .create(document.querySelector('#titulo'))
            //     .catch(error => {
            //         console.error(error);
            //     });
            ClassicEditor
                .create(document.querySelector('#editor_short'))
                .catch(error => {
                    console.error(error);
                });
        </script>
    </div>
</div>



@endsection