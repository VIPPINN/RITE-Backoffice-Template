@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar Permiso</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('permisos.index')}}">Inicio</a></li>
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
        <form action="{{ route('permisos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <header>Nombre</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="nombre" name="nombre" placeholder="Ingrese nombre del permiso" style="width:60%"></input>
                            {{ csrf_field() }}
                            @if ($errors->has('title'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el nombre.</small>
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
     
    </div>
</div>



@endsection