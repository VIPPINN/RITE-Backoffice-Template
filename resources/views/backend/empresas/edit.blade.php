@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Usuario: {{ $usuario->razonSocial }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('empresas.index')}}">Inicio</a></li>
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
        <form action="{{ route('empresas.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="title">Razon Social</label><br>
                            <input id="titulo" name="razonSocial" value="{{ $usuario->razonSocial }}" style="width:60%"></input>
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
                            <label for="title">CUIT</label><br>
                            <input id="titulo" name="cuit" value="{{ $usuario->CUIT}}" style="width:60%"></input>
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
                            <label for="title">Email Principal</label><br>
                            <input id="titulo" name="email" value="{{ $usuario->email}}" style="width:60%"></input>
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
                            <label for="title">Email Secundario</label><br>
                            <input id="titulo" name="email2" value="{{ $usuario-> emailSecundario}}" style="width:60%"></input>
                            {{ csrf_field() }}
                            @if ($errors->has('name'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

              <!-- Selector de Provincia-->
              <div class="container"><br /></div>
              <div class="container"> 
                  <div class="row">
                  <header>Provincia</header>
                      <div class="col-sm">
                          <div class="form-group">
                              <select name="provincia" id="tipo" style="width:300px">
                                  <option value="{!! $usuario-> idProvincia!!}">{!! $usuario->nombreProvincia!!}</option>
                                  @foreach ($provincias as $indexProvincia => $provincia)
                                  @if ($usuario->nombreProvincia != $provincia->nombre)
                                  <option value="{!! $provincia -> id !!}">{!!$provincia->nombre!!}</option>
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
                            <label for="title">Nombre de Fantasía</label><br>
                            <input id="titulo" name="fantasia" value="{{ $usuario-> nombreFantasia}}" style="width:60%"></input>
                            {{ csrf_field() }}
                            @if ($errors->has('name'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="container"><br/></div>

            <div class="container">      
                  <div class="col-sm-6">
                      <div class="form-group">
                          <label for="color">&nbsp;</label><br>
                          <div class="form-check">
                            @if( $usuario->esPionera == 1)
                          <input type="checkbox" class="form-check-input" id="estado" name="esPionera" checked> 
                          @else
                          <input type="checkbox" class="form-check-input" id="estado" name="esPionera" > 
                          @endif
                          <label class="form-check-label" for="estado">Es Pionera</label>
                          </div>
                      </div>
                  </div>
            </div> 

            <div class="container"><br /></div>
            <div class="container">
            <div class="row">
                <div class="form-group">
                  <label>Logo</label>
                  <input type="file" name="logo" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" style="width:60%">
                  <img src="{{ asset(env('PATH_FILES')) }}/Usuario/{{$usuario->logo}}" 
                  alt="" 
                  width="100">
                  @if ($errors->has('logo'))
                  <small id="titleError" class="form-text text-danger">{{ $errors->first('logo') }}</small>
                    @endif
                </div>
              </div>
            </div>
           

             <!-- Selector de Grupo Usuario-->
             <div class="container"><br /></div>
            <div class="container"> 
                <div class="row">
                <header>Grupo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="grupo" id="tipo" style="width:300px">
                                <option value="{!! $usuario-> grupoId!!}">{!! $usuario->grupo!!}</option>
                                @foreach ($grupos as $index => $grupo)
                                @if ($usuario->grupo != $grupo->descripcion)
                                <option value="{!! $grupo -> id !!}">{!!$grupo->descripcion!!}</option>
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