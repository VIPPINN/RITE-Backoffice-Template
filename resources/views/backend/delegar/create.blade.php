@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar una relacion</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('delegar.index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Agregar</li>
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
        <form action="{{ route('delegar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
          
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Usuario</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="usuario" id="tipo" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($usuarios as $index => $usuario)
                                <option value="{!!$usuario->id!!}">{!!$usuario->apellido!!},{!!$usuario->nombre!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Selector de tipo de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Empresa</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="empresa" id="tipo" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($empresas as $index => $empresa)
                                <option value="{!!$empresa->id!!}">{!!$empresa->razonSocial!!}</option>
                                @endforeach
                            </select>
                            {{ csrf_field() }}
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
            
        </script>
    </div>
</div>



@endsection