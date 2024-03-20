@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Agregar un registro </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('acuerdosIndex') }}">Inicio</a></li>
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
            <form action="{{ route('acuerdosUpdate', $acuerdo->id )}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="titleSlider">Título</label>
                                <input class="form-control" value="{{ $acuerdo->titulo }}" name="title"
                                    aria-describedby="titleError" placeholder="Ingrese un título" maxlength="150">
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
                                <label> PDF </label>
                                <input type="file" name="pdf" value="{{ old('pdf') }}" accept="application/pdf"
                                    class="form-control{{ $errors->has('pdf') ? ' is-invalid' : '' }}">
                                <span class="text-center ml-2">
                                    <a title="Enviar Acceso"
                                        href="{{ asset(env('PATH_FILES')) }}/Comunidad/{{ $acuerdo->pdf }}" target="_blank">
                                        <i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                                    </a></span>
                                @if ($errors->has('imagepc'))
                                    <small id="linkError" class="form-text text-danger">{{ $errors->first('pdf') }}</small>
                                @endif
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
