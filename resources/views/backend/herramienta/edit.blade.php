@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Herramienta: {!! $herramienta->titulo!!}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('herramienta.index')}}">Inicio</a></li>
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
        <form action="{{ route('herramienta.update', $herramienta->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">titulo</label><br>
                            <textarea class="titulo-textarea" name="titulo" placeholder="Ingrese el texto...">{{ $herramienta->titulo }}</textarea>
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
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Descripcion</label><br>
                            <textarea class="descripcion-textarea" name="descripcion" placeholder="Ingrese el texto...">{{ $herramienta->descripcion }}</textarea>
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
                <div class="row">
                <header>Tipo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tipo" id="tipo" style="width:300px">
                            @foreach($herramientaTipo as $index => $tipo)
                                @if( $herramienta->descripcionTipo  == $tipo->descripcion)
                                    <option selected value="{{$tipo->id}}">{!!$tipo->descripcion!!}</option>
                                @else
                                    <option  value="{{$tipo->id}}">{!!$tipo->descripcion!!}</option>
                                @endif
                           
                            @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container"><br /></div>
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">PDF</label><br>
                            
                            <input type="file" name="pdf" accept="application/pdf" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" style="width:63.1%;">
                            @if($herramienta->pdf != "")
                                <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES')) }}/Herramienta/{{ $herramienta->pdf }}"   target="_blank"><i class="far fa-file-pdf" style="color:red; width:20px;height:20px"></i>
                                </a>
                            @endif
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
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Excel</label><br>
                            
                            <input type="file" name="excel" accept="application/xlsx" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" style="width:63.1%;">
                            @if($herramienta->excel != "")
                            <a title="Enviar Acceso" href="{{ asset(env('PATH_FILES')) }}/Herramienta/{{ $herramienta->excel }}"   target="_blank"><i class="far fa-file-excel" style="color:green; width:20px;height:20px"></i>
                                </a>
                            @endif
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
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Video</label><br>
                            <input id="titulo" name="link" value="{{ $herramienta->linkVideo }}" style="width:60%"></input>
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
                <div class="row">
                <header>Activo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="activo" id="tipo" style="width:300px">
                            @if( $herramienta->activo == 0)
                                <option selected value="0">Inactivo</option>
                             
                                <option value="1">Activo</option>
                            @else
                            <option value="0">Inactivo</option>
                             
                             <option selected value="1">Activo</option>
                            </select>
                            @endif
                            {{ csrf_field() }}
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
                            <input id="orden" name="orden"  style="width:30px" value="{{ $herramienta->orden }}" ></input>
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
                ClassicEditor
                .create(document.querySelector('#editor_short'))
                .catch(error => {
                    console.error(error);
                });

            
        </script>
    </div>
</div>

@endsection