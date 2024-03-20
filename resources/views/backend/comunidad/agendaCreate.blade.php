@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Agregar un registro </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('agendaIndex') }}">Inicio</a></li>
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
            <form action="{{ route('agendaStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="titleSlider">Título</label>
                                <input class="form-control" value="{{ old('title') }}" name="title"
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
                                <label for="titleSlider">Descripcion</label>
                                <input class="form-control" value="{{ old('descripcion') }}" name="descripcion"
                                    aria-describedby="titleError" placeholder="Ingrese un título" maxlength="150">
                                @if ($errors->has('descripcion'))
                                    <small id="videoError"
                                        class="form-text text-danger">{{ $errors->first('descripcion') }}</small>
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
                                <input type="file" name="imagepc" value="{{ old('imagepc') }}"
                                    class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">

                                @if ($errors->has('imagepc'))
                                    <small id="linkError"
                                        class="form-text text-danger">{{ $errors->first('imagepc') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Modalidad</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <select name="modalidad" id="modalidad" style="width:300px">
                                    <option selected value="">Seleccione...</option>
                                    @foreach ($modalidades as $index => $modalidad)
                                        <option value="{{ $modalidad->id }}">{!! $modalidad->descripcion !!}</option>
                                    @endforeach
                                </select>
                                {{ csrf_field() }}
                                @if ($errors->has('modalidad'))
                                    <small id="linkError"
                                        class="form-text text-danger">{{ $errors->first('modalidad') }}</small>
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
                                <label for="fecha">Fecha:</label><br />
                                <input type="date" id="fecha" name="fecha">
                                @if ($errors->has('fecha'))
                                <small id="linkError"
                                    class="form-text text-danger">{{ $errors->first('fecha') }}</small>
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
                                <label for="fecha">Hora:</label><br />
                                <input type="time" id="hora" name="hora">
                                @if ($errors->has('hora'))
                                <small id="linkError"
                                    class="form-text text-danger">{{ $errors->first('hora') }}</small>
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
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
