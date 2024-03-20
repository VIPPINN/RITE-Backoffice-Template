@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Registro</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('about.index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
        </ol>
    </nav>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Verifique los errores marcados.<br>
    </div>
    @elseif ($messageWarning = Session::get('ErrorStatus'))
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
        <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Titulo</label>
                            {{-- <textarea id="titulo" name="titulo" placeholder="Ingrese el texto...">{{ $about->titulo }}</textarea> --}}
                            <input id="titulo" name="titulo" type="text"
                                    placeholder="Ingrese Titulo" 
                                    value="{{ $about->titulo }}"
                                    class="form-control">
                            {{ csrf_field() }}
                            @if ($errors->has('titulo'))
                            <small id="titleError" class="form-text text-danger">{{ $errors->first('titulo') }}</small>
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
                            <label for="text">Texto Resumido</label>
                            <textarea id="editor_short" name="editor_short" placeholder="Ingrese el texto...">{{ $about->descripcionCorta }}</textarea>
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
                            <label for="text">Texto Detallado</label>
                            <textarea id="editor_large" name="editor_large" placeholder="Ingrese el texto...">{{ $about->descripcionLarga }}</textarea>
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
                          <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES')) }}/{{ $about->enlacePdf }}"   target="_blank">
                            <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                          </a>
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
                                    <label for="color">&nbsp;</label><br>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"   <?php echo $about->estado == 1 ? 'checked' : ''; ?> @if(old('status') == 'on') checked  @endif id="status" name="status">
                                        <label class="form-check-label" for="status">Activo</label> &nbsp; &nbsp;
                                        @if ($errors->has('status'))
                                            <small id="linkError" class="form-text text-danger">{{ $errors->first('status') }}</small>
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
                        <button type="submit" class="btn btn-primary">Editar</button>
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