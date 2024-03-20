@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Registro</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('faqs.index')}}">Inicio</a></li>
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
        <form action="{{ route('faqs.update', $faqs->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Título/Pregunta</label>
                            <input id="titulo" name="titulo" type="text"
                                    placeholder="Ingrese Titulo" 
                                    value="{{ $faqs->titulo }}"
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
                            <label for="text">Respuesta</label>
                            <textarea id="editor" name="editor" placeholder="Ingrese el texto...">{{ $faqs->texto }}</textarea>
                            {{ csrf_field() }}

                            @if ($errors->has('editor'))
                            <small id="linkError" class="form-text text-danger">{{ $errors->first('editor') }}</small>
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
                        
                            <label for="color">&nbsp;</label><br>
                            <div class="col-sm-4"><input style="width:60px" id="orden" name="orden" value="{{ $faqs->orden}}"><br>
                                @if ($errors->has('orden'))
                                <small id="linkError" class="form-text text-danger">{{ $errors->first('orden') }}</small>
                                @endif
                            </div>

                            <div class="col-sm-4">

                                <input type="checkbox" class="form-check-input" <?php echo $faqs->estado == 1 ? 'checked' : ''; ?> id="status" name="status">
                                <label class="form-check-label" for="status">Activo</label>

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
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</div>
</div>

@endsection