@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4"> Editar Orientado Recurso: {{ $orientadoRecurso->titulo }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orientadoRecurso.index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
        <form action="{{ route('orientadoRecurso.update', $orientadoRecurso->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Titulo</label>
                            <br>
                            <input id="titulo" name="titulo" value="{{ $orientadoRecurso->titulo }}" style="width:60%"></textarea>
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
                            <label for="text">Descripcion</label>
                            <textarea id="editor" name="editor" placeholder="Ingrese el texto...">{{ $orientadoRecurso->descripcion}}</textarea>
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
                    <div class="col-sm">
                        <div class="form-group">

                        
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="color">&nbsp;</label><br>
                                    <div class="form-check">

                                        <input type="checkbox" class="form-check-input" <?php echo $orientadoRecurso->estado == 1 ? 'checked' : ''; ?> id="status" name="status">
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