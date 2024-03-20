@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Agregar Video</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('videos.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Agregar</li>
    </ol>
  </nav>

  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Verifique los errores marcados.<br>
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
    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="container">
        


        <div class="row">
          <div class="col-sm">
              <div class="form-group">
                <label for="title">Título</label>
                  <textarea  id="title" name="title" placeholder="Ingrese el texto...">{{ old('title') }}</textarea>
                  {{ csrf_field() }}
                  @if ($errors->has('title'))
                  <small id="linkError" class="form-text text-danger">{{ $errors->first('title') }}</small>
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
              <label for="link">Link</label>
              <input type="text" class="form-control" id="link" value="{{ old('link') }}" name="link" aria-describedby="linkError" placeholder="Ingrese el codigo del video en YouTube por ej. 6of8UcBMi1M">
              @if ($errors->has('link'))
                <small id="linkError" class="form-text text-danger">{{ $errors->first('link') }}</small>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm">
            <div class="form-group">
                <label for="color">&nbsp;</label>
                <div class="form-check">
                    <label class="form-check-label" for="status">Activo</label>
                    <input type="checkbox" class="form-check-input" @if(old('status') == 'on') checked  @endif   id="status" name="status"><br>
                    @if ($errors->has('status'))
                        <small id="titleError" class="form-text text-danger"> {{ $errors->first('status') }}</small>
                    @endif
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container"><br/></div>
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

<script src={{ asset('ckeditor/ckeditor.js') }}></script>
<script>
    ClassicEditor
        .create(document.querySelector('#title'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection