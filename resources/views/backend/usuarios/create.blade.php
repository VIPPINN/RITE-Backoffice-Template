@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Agregar un Usuario</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Inicio</a></li>
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
            <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container">
                    <header>Nombre</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="nombre" name="nombre" placeholder="Ingrese Nombre" style="width:60%" value="{{ old('nombre') }}"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('nombre'))
                                    <small id="titleError" class="form-text text-danger">*Campo requerido.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Apellido</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="titulo" name="apellido" placeholder="Ingrese Apellido"
                                    style="width:60%" value="{{ old('apellido') }}"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('apellido'))
                                    <small id="titleError" class="form-text text-danger">*Campo requerido.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Email Principal</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="titulo" name="email" placeholder="Ingrese Email Principal"
                                    style="width:60%" value="{{ old('email') }}"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('email'))
                                    <small id="titleError" class="form-text text-danger">*Campo requerido.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Email Secundario</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="titulo" name="email2" placeholder="Ingrese Email Secundario"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('title'))
                                    <small id="titleError" class="form-text text-danger">Se ha producido un error al
                                        ingresar el título.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Cuit</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="titulo" name="cuit" placeholder="Ingrese CUIT" style="width:60%" value="{{ old('cuit') }}"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('cuit'))
                                    <small id="titleError" class="form-text text-danger">*Campo requerido.</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>
                <div class="container">
                    <header>Password</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <input id="titulo" name="password" placeholder="Ingrese Password"
                                    style="width:60%"></input>
                                {{ csrf_field() }}
                                @if ($errors->has('password'))
                                    <small id="titleError" class="form-text text-danger">*Campo requerido.</small>
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
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                                {{ csrf_field() }}
                                @if ($errors->has('roles'))
                                <small id="titleError" class="form-text text-danger">*Campo requerido.</small>
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
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });

            function tipoAutorizado() {
                var selector = document.getElementById("tipo").value;
                var selector2 = document.getElementById("nombre_delegado");
                if (selector == 6) {
                    selector2.style.display = "block";
                }

            }
        </script>
    </div>
    </div>
@endsection
