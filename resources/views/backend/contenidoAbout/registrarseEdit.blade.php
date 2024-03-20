@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Agregar tarjeta de registro </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Inicio</a></li>
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
            <form action="{{ route('actualizarRegistro', $registro->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="titleSlider">titulo</label>
                                <input id="title" class="form-control" value="{{ $registro->titulo }}"
                                    name="title" aria-describedby="titleError" placeholder="Ingrese un título"
                                    maxlength="150">
                                @if ($errors->has('title'))
                                    <small id="titleError"
                                        class="form-text text-danger">{{ $errors->first('title') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <header>Descripcion</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <textarea class="descripcion-textarea" id="editor" name="descripcion" maxlength="2000" >{{ $registro->descripcion }}</textarea>
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

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">

                                <label> PDF</label>
                                <input type="file" name="pdf" accept="application/pdf"
                                    class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                                @if (!empty($registro->pdf))
                                    <a title="Documento Actual"
                                        href="{{ asset(env('PATH_FILES')) }}/ComoRegistrarse/{{ $registro->pdf }}"
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="color">&nbsp;</label><br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="estado" name="status" {{ $registro->estado == 1 ? "checked" : ""}}>
                                <label class="form-check-label" for="estado">Activo</label>
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

        ClassicEditor
            .create(document.querySelector('#editor2'))
            .catch(error => {
                console.error(error);
            });
    </script>

@endsection

