@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Agregar Noticia</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('news.index')}}">Inicio</a></li>
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
    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="container">
        

        <div class="row">
          <div class="col-sm">
              <div class="form-group">
                <label for="title">Título</label>
                  <textarea  id="title" name="title" placeholder="Ingrese el texto...">{{ old('title') }}</textarea>
                  {{ csrf_field() }}
                  @if ($errors->has('title'))
                  <small id="linkError" class="form-text text-danger">{{ $errors->first('title') }} <!--Se ha producido un error al ingresar el título. --> </small>
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
                  <label for="txt_short">Texto Resumido</label>
                    <textarea  id="txt_short" name="txt_short" placeholder="Ingrese el texto...">{{ old('txt_short') }}</textarea>
                    {{ csrf_field() }}
                    @if ($errors->has('txt_short'))
                    <small id="linkError" class="form-text text-danger">{{ $errors->first('txt_short') }} <!--Se ha producido un error al ingresar el texto. --></small>
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
                  <label for="txt_large">Texto Detallado</label>
                    <textarea  id="txt_large" name="txt_large" placeholder="Ingrese el texto...">{{ old('txt_large') }}</textarea>
                    {{ csrf_field() }}
                    @if ($errors->has('txt_large'))
                    <small id="linkError" class="form-text text-danger">{{ $errors->first('txt_large') }} <!--Se ha producido un error al ingresar el texto. --> </small>
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
              <label> Fecha</label>
              <input type="text" class="form-control" 
                    id="fecha" value="{{ old('fecha') }}" 
                    name="fecha" aria-describedby="linkError" 
                    autocomplete="off"
                    placeholder="Ingrese un título">
              @if ($errors->has('fecha'))
                <small id="linkError" class="form-text text-danger"> {{ $errors->first('fecha') }} <!--Se ha producido un error al ingresar la fecha.--> </small>
                @endif
              </div>
          </div>


          <div class="col-sm">
            <div class="form-group">
              <label> Imagen</label>
              <input type="file" name="image" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
                @if ($errors->has('file'))
                    <small id="titleError" class="form-text text-danger">{{ $errors->first('file') }}</small>
                @endif
            </div>
          </div>
          
        </div>
      </div>
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <label class="form-check-label" for="orden">Orden &nbsp;</label>
                <input style="width:60px" value="{{ $ultimoNumeroDeOrden + 1 }}" 
                        id="orden" name="orden" placeholder="Orden..."><br>
                @if ($errors->has('orden'))
                <small id="linkError" class="form-text text-danger">{{ $errors->first('orden') }}</small>
                @endif
            </div>
            <div class="col-sm-6">
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


        $(document).ready(function() {  
            $( "#fecha").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'dd-mm-yy',
              firstDay: 1, // The first day of the week, Sun = 0, Mon = 1, ...
              closeText: 'Cerrar', // Display text for close link
              prevText: 'Anterior', // Display text for previous month link
              nextText: 'Siguiente', // Display text for next month link
              monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'], // Names of months for drop-down and formatting
              monthNamesShort: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'], // For formatting
              dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'], // For formatting
              dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'], // For formatting
              dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'] // Column headings for days starting at Sunday
        });
  
       });

       $("#orden").numeric();

        
</script>

@endsection