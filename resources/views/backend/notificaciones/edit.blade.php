@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Usuario: {{ $notificacion->asunto }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('notificacionEnviada.index')}}">Inicio</a></li>
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
        <form action="{{ route('notificacionEnviada.update', $notificacion->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="container">
                <header>Asunto</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="asunto" value="{{ $notificacion->asunto }}"  style="width:60%"></input>
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
                            <textarea id="titulo" name="mensaje" maxlength="255" value=""style="width:60%;height:100px">{{ $notificacion -> notificacion }}</textarea>
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
                        <select multiple="multiple" name="destinatarios[]" id="destinatarios" style="width:300px">
                        <option value="0" >Todos</option>
                        
                            @foreach($usuarios as $indexUsuario => $usuario)
                           
                                  
                                        <option value="{{$usuario->id}}" >{{$usuario->apellido}}, {{ $usuario->nombre }}</option>
                                   
                                
                            
                        @endforeach
                            </select>
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

                                    
                                @foreach ($tipoNotificaciones as $index => $tipoNotificacion)
                                @if($notificacion->descripcion == $tipoNotificacion->descripcion)
                                    <option value="{{$tipoNotificacion->id}}" selected >{{$tipoNotificacion->descripcion}}</option>
                                @else
                                    <option value="{{$tipoNotificacion->id}}">{{$tipoNotificacion->descripcion}}</option>
                                @endif
                                @endforeach
                                
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