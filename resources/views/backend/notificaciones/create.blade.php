@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar una Notificacion</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('notificacionEnviada.index')}}">Inicio</a></li>
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
        <form action="{{ route('notificacionEnviada.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            
            <div class="container">
                <header>Asunto</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="asunto" placeholder="Ingrese Asunto" style="width:60%"></input>
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
                <header>Mensaje</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <textarea id="titulo" name="mensaje" maxlength="255" placeholder="Ingrese el texto..." style="width:60%;height:100px"></textarea>
                            {{ csrf_field() }}
                            @if ($errors->has('title'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

           

            <!-- Selector de destinatario -->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Destinatario/s</header>
                    <div class="col-sm">
                        <div class="form-group">
                        <input list="destinatarios" name="destinatario" id="destinatario" style="width:300px">
                        <datalist id="destinatarios">
                            <option value="Todos">
                                @foreach($usuarios as $indexUsuario => $usuario)
                                    <option value="{{$usuario->CUIT}} - {{$usuario->razonSocial}}">
                                @endforeach
                            </datalist>
                         
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

          
           
           
            <!-- Selector de tipo de notificacion-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Tipo Notificacion</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tipo" id="tipo" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($tipos as $index => $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
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