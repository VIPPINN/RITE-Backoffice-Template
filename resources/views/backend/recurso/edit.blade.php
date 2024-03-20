@extends('backend.app')

@section('content')
@foreach ($recurso as $index => $recurso)
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Recurso: {{ $recurso->titulo }}
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('recurso.index')}}">Inicio</a></li>
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
        <form action="{{ route('recurso.update', $recurso->id) }}" method="POST" enctype="multipart/form-data">
            
            @csrf
            @method('PUT')
            <div class="container">
                <header>Titulo</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="titulo" value="{!! $recurso->titulo!!}" style="width:60%"></input>
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
            <header>Descripcion</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">

                            <textarea id="editor" name="editor" placeholder="Ingrese la descripcion...">{!! $recurso->descripcion!!}</textarea>
                            {{ csrf_field() }}
                            @if ($errors->has('title'))
                            <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el texto.</small>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
            <div class="container"><br /></div>
            <div class="container">

                <div class="row">
                    <header>Link de Descarga</header>
                    <div class="col-sm">
                        <div class="form-group">

                            <input type="text" id="descargarLink" name="descargarLink" value="{!! $recurso->descarga!!}" >

                            @if ($errors->has('title'))
                            <small id="linkError" class="form-text text-danger">Se ha producido un error al ingresar el texto.</small>
                            @endif

                            
                        </div>

                    </div>
                </div>


            </div>

            <!-- Selector de tipo de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                <header>Tipo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tipo" id="tipo" style="width:300px">
                                <option value="{!! $recurso->tipoRecursoId!!}">{!! $recurso->tipoRecursoTitulo!!}</option>
                                @foreach ($tipoRecurso as $index => $tipoRecurso)
                                @if ($recurso->tipoRecursoTitulo != $tipoRecurso->titulo)
                                <option value="{!!$tipoRecurso->id!!}">{!!$tipoRecurso->titulo!!}</option>
                                @endif
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selector de orientaddo a de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Orientado a</header>
                    
                    <div class="col-sm">
                        <div class="form-group">
                        @foreach ($orientadoRecurso as $index => $valor)
                        <?php $entro= false;?>
                            @foreach($orientado as $index2 => $val)
                                @if($val->recursoId == $recurso->id && $valor->id == $val->orientadoId)
                                <?php $entro= true;?>
                                @endif
                                
                            @endforeach
                            <?php if($entro){?>
                                <input type="checkbox" name="orientado{{$index}}" id="orientado{{$index}}" value="{!!$valor->id!!}" checked>
                                <label class="form-check-label" for="status">{!!$valor->titulo!!}</label><br>
                                <?php $entro=true;?>
                            
                                <?php } else {?>
                                    <input type="checkbox" name="orientado{{$index}}" id="orientado{{$index}}" value="{!!$valor->id!!}">
                                <label class="form-check-label" for="status">{!!$valor->titulo!!}</label><br>
                                <?php } ?>
                        @endforeach
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selector de origen de recurso-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                <header>Origen</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="origen" id="origen" style="width:300px">
                                <option value="{!! $recurso->origenRecursoId!!}">{!! $recurso->origenRecursoTitulo!!}</option>
                                @foreach ($origenRecurso as $index => $origenRecurso)
                                @if ($recurso->origenRecursoTitulo != $origenRecurso->titulo)
                                <option value="{!!$origenRecurso->id!!}">{!!$origenRecurso->titulo!!}</option>
                                @endif
                                @endforeach
                            </select>
                            {{ csrf_field() }}
                        </div>
                    </div>
                </div>
            </div>

             <!-- Selector de tema de recurso-->
             <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                <header>Tema</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="tema" id="tema" style="width:300px">
                                <option value="{!! $recurso->temaRecursoId!!}">{!! $recurso->temaRecursoTitulo!!}</option>
                                @foreach ($temaRecurso as $index => $temaRecurso)
                                @if ($recurso->temaRecursoTitulo != $temaRecurso->titulo)
                                <option value="{!!$temaRecurso->id!!}">{!!$temaRecurso->titulo!!}</option>
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
                        <div class="form-group">


                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="color">&nbsp;</label><br>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" <?php echo $recurso->status == 1 ? 'checked' : ''; ?> id="status" name="status">
                                        <label class="form-check-label" for="status">Activo</label>
                                    </div>
                                </div>
                            </div>
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


@endforeach
@endsection