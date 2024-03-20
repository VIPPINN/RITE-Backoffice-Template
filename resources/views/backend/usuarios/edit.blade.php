@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Editar Usuario: {{ $usuario->nombre }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Inicio</a></li>
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
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="title">Nombre</label><br>
                                <input id="titulo" name="nombre" value="{{ $usuario->nombre }}"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('name'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
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
                                <label for="title">Apellido</label><br>
                                <input id="titulo" name="apellido" value="{{ $usuario->apellido }}"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('name'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
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
                                <label for="title">CUIT</label><br>
                                <input id="titulo" name="cuit" value="{{ $usuario->CUIT }}"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('name'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
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
                                <label for="title">Email Principal</label><br>
                                <input id="titulo" name="email" value="{{ $usuario->email }}"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('name'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
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
                                <label for="title">Email Secundario</label><br>
                                <input id="titulo" name="email2" value="{{ $usuario->emailSecundario }}"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('name'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            
             

                <!-- Selector de roles-->
                <div class="container"><br /></div>
                <div class="container">
                    <div class="row">
                        <header>Roles</header>
                        <div class="col-sm">
                            <div class="form-group">
                                @foreach ($roles as $role)
                                    <div>
                                        <label>
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                {{ $usuario->hasRole($role) ? 'checked' : '' }}>
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                                {{ csrf_field() }}
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
