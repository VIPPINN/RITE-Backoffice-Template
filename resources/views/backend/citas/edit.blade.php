@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Editar Cita</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('citas.index') }}">Inicio</a></li>
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
            <form action="{{ route('citas.update', $cita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="titleSlider">Cita</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $cita->texto }}" aria-describedby="titleError" placeholder="Ingrese Cita" maxlength="150">
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
                                <label for="link">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario"
                                    value="{{ $cita->usuarioCita }}" aria-describedby="linkError"
                                    placeholder="Ingrese usuario" maxlength="30">
                                @if ($errors->has('link'))
                                    <small id="linkError" class="form-text text-danger">{{ $errors->first('link') }}</small>
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
                                <label> Imagen</label>
                                <input type="file" name="imagepc"
                                    class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                                <img src="{{ asset(env('PATH_FILES')) }}/CitasIconos/{{ $cita->icono }}" width="60">
                                {!! $errors->first(
                                    'imagepc',
                                    '<span class="text-danger">Se ha producido un error al ingresar la imagen (:message)</span>',
                                ) !!}
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="color">&nbsp;</label><br>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" <?php echo $cita->estado == 1 ? 'checked' : ''; ?> id="status"
                                        name="status">
                                    <label class="form-check-label" for="status">Activo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container"><br /></div>


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
@endsection
