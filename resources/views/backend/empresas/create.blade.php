@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Agregar una Empresa</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('empresas.index')}}">Inicio</a></li>
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
        <form action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <header>Razon Social</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="razonSocial" placeholder="Ingrese Razon Social" style="width:60%"></input>
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
                <header>Cuit</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="cuit" placeholder="Ingrese CUIT" style="width:60%"></input>
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
                <header>Email Principal</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="email" placeholder="Ingrese email principal" style="width:60%"></input>
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
                <header>Email Secundario</header>
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <input id="titulo" name="email2" placeholder="Ingrese email secundario" style="width:60%"></input>
                            {{ csrf_field() }}
                            @if ($errors->has('title'))
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
                                 <option value="">Seleccione...</option>
                                 @foreach ($provincias as $indexProvincia => $provincia)
                                 <option value="{!!$provincia->id!!}">{!!$provincia->nombre!!}</option>
                                 @endforeach
                             </select>
                             {{ csrf_field() }}
                         </div>
                     </div>
                 </div>
             </div>

             <div class="container"><br /></div>
             <div class="container">
                 <header>Nombre de Fantasía</header>
                 <div class="row">
                     <div class="col-sm">
                         <div class="form-group">
                             <input id="titulo" name="fantasia" placeholder="Ingrese nombre de fantasía" style="width:60%"></input>
                             {{ csrf_field() }}
                             @if ($errors->has('title'))
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
                           <input type="checkbox" class="form-check-input" id="estado" name="esPionera">
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
                    @if ($errors->has('file'))
                        <small id="titleError" class="form-text text-danger">{{ $errors->first('file') }}</small>
                    @endif
                </div>
              </div>
            </div>
           
            <!-- Selector de Grupo-->
            <div class="container"><br /></div>
            <div class="container">
                <div class="row">
                    <header>Grupo</header>
                    <div class="col-sm">
                        <div class="form-group">
                            <select name="grupo" id="tipo" style="width:300px">
                                <option value="">Seleccione...</option>
                                @foreach ($grupos as $index => $grupo)
                                <option value="{!!$grupo->id!!}">{!!$grupo->descripcion!!}</option>
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