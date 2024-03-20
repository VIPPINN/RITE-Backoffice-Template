@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Novedades</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('news.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Ver</li>
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
    <div class="container">
      <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="title"><strong>Título</strong></label> <br>
                <span>{!! $news->titulo !!}</span>
                @if ($errors->has('title'))
                <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                @endif
            </div>
        </div>
    </div>
    </div>
    <div class="container"><br/></div>
      <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="form-group">
                    <label for="txt_short"><strong>Texto Resumido</strong></label>
                    <span>{!! $news->descripcionCorta !!}</span>
                   
                    @if ($errors->has('txt_short'))
                    <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                    @endif
                </div>
            </div>
        </div>
      </div>
    <div class="container"><br/></div>

    <div class="container">
      <div class="row">
          <div class="col-sm">
              <div class="form-group"> 
                  <label for="txt_large"><strong>Texto Detallado</strong></label><br>
                  <span>{!! $news->descripcionLarga !!}</span>

                  @if ($errors->has('txt_large'))
                  <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                  @endif
              </div>
          </div>
      </div>
    </div>

    <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          
          <div class="col-sm">
            <div class="form-group">
              <label> <strong>Imagen </strong></label> <br>
             
              <img src="{{ asset(env('PATH_FILES')) }}/news/thumb-{{$news->imagenPublicacion}}" 
                  alt="{{ $news->imagenPublicacion }}" 
                  width="60">
              {!!$errors->first('image', '<span class="text-danger">:message</span>')!!}
            </div>
          </div>
        </div>
      </div>
    <div class="container"><br/></div>
  

    <div class="container">
      <div class="row">
        
        <div class="col-sm">
          <div class="form-group">
            <label for="color"><strong>Estado:</strong> &nbsp;</label><br>
            <div class="form-check">
              @if ($news->estado == 1)
                  <span class='badge bg-success' style='color:White;'>
                    Activo
                  </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<script src={{ asset('ckeditor/ckeditor.js') }}></script>
<script>

        ClassicEditor
        .create(document.querySelector('#title'))
        .catch(error => {
            console.error(error);
        });

        ClassicEditor
        .create(document.querySelector('#txt_short'))
        .catch(error => {
            console.error(error);
        });
        ClassicEditor
        .create(document.querySelector('#txt_large'))
        .catch(error => {
            console.error(error);
        });

        
</script>

@endsection