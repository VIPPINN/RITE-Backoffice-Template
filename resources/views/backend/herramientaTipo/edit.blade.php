@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Tipo Herramienta: {{ $tipoHerramienta->descripcion}}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('herramientaTipo.index')}}">Inicio</a></li>
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
        <form action="{{ route('herramientaTipo.update', $tipoHerramienta->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Descripcion</label><br>
                            <input id="titulo" name="descripcion" value="{{ $tipoHerramienta->descripcion }}" style="width:60%"></input>
                            {{ csrf_field() }}
                            @if ($errors->has('name'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="container"><br /></div>
           
           <div class="container">
               <header>Orden</header>
               <div class="row">
                   <div class="col-sm">
                       <div class="form-group">
                           <input id="orden" name="orden" style="width:5%" value='{{$tipoHerramienta->orden}}'>
                           {{ csrf_field() }}
                         
                       </div>
                   </div>
               </div>
           </div>


             <!-- Selector de Grupo Usuario-->
             <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                <header>Activo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="activo" id="tipo" style="width:300px">
                            @if($tipoHerramienta->activo == 0)
                                <option value="0" selected>Inactivo</option>
                             
                                <option value="1">Activo</option>
                            @else
                            <option value="0" >Inactivo</option>
                             
                                <option value="1" selected>Activo</option>
                            @endif
                            </select>
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