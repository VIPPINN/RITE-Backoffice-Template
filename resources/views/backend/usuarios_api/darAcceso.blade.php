@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Agregar un Usuario API</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('usuarios_api.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Agregar</li>
            </ol>
        </nav>

        @if ($message = Session::get('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ $message }}
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
            <form action="{{ route('usuarios_api.cargarAcceso') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container"><br /></div>
                <div class="container">
                    <header>Seleccionar Usuario</header>
                    <div class="row">
                        <div class="col-sm">
                        <select name="usuario_api" id="">
                            @foreach($usuarios as $usuario)
                                <option value="{{$usuario->id}}">{{$usuario->apellido}},{{$usuario->nombre}}</option>
                            @endforeach
                        </select>
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
    </div>
    </div>
@endsection
