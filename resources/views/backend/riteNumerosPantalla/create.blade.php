@extends('backend.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Agregar un Informe o Estadística</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Inicio</a></li>
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
            <form action="{{ route('guardarEstadistica') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="container">
                    <header>titulo</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <textarea class="titulo-textarea" maxlength="88" name="titulo" placeholder="Ingrese el texto...">{{ old('titulo') }}</textarea>
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
                    <header>Descripcion</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <textarea class="descripcion-textarea" name="descripcion" maxlength="255" placeholder="Ingrese el texto...">{{ old('descripcion') }}</textarea>
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

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label> Archivo de Descarga</label>
                                <input type="file" name="pdf" 
                                    class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                                <small id="linkError" class="form-text text-danger"> {{ $errors->first('file') }}
                                    <!--Se ha producido un error al ingresar la fecha.-->
                                </small>
                                <!--{!! $errors->first('file', '<span class="text-danger"> Se ha producido un error al ingresar la imagen.</span>') !!} -->
                            </div>
                        </div>

                        <div class="col-sm"> </div>
                    </div>
                </div>


                <div class="container"><br /></div>
                <div class="container">
                    <header>Tipo</header>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <select name="tipo" id="tipo" style="width:300px" onchange="validarMiniatura()">
                                    <option selected value="">Seleccione...</option>
                                    @foreach ($tipos as $index => $tipo)
                                        <option value="{{ $tipo->id }}">{!! $tipo->descripcion !!}</option>
                                    @endforeach
                                </select>
                                {{ csrf_field() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container"><br /></div>

                <div class="container" id="miniatura">

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Miniatura</label>
                                <input type="file" name="miniatura" 
                                    class="form-control{{ $errors->has('miniatura') ? ' is-invalid' : '' }}">
                                <small id="linkError" class="form-text text-danger"> {{ $errors->first('miniatura') }}
                                    <!--Se ha producido un error al ingresar la fecha.-->
                                </small>
                                <!--{!! $errors->first('miniatura', '<span class="text-danger"> Se ha producido un error al ingresar la imagen.</span>') !!} -->
                            </div>
                        </div>

                        <div class="col-sm"> </div>
                    </div>
                </div>


                

                <div class="container"><br /></div>
                <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="color">&nbsp;</label><br>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status">
                                <label class="form-check-label" for="status">Activo</label>
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
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
        </form>
        
        <script>
            let miniatura = document.getElementById('miniatura');
            miniatura.style.display = 'none';

            function validarMiniatura(){
                let tipo = document.getElementById('tipo');
                if(tipo.value == 1){
                    miniatura.style.display = 'block';
                }
            }
        </script>
    </div>
    </div>



@endsection
