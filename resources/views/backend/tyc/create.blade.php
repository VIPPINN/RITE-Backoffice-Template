@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Agregar Términos y Condiciones</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('tyc.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Agregar</li>
    </ol>
  </nav>

 <!--  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Verifique los errores marcados.<br> 
        <span>$errors</span>  
    </div>
  @endif -->

  <ul>  
    @foreach ($errors->all() as $error)
        <strong>Oops!</strong> Verifique los errores marcados.<br> 
        <li>{{ $error }}</li>
    @endforeach
</ul>
    
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
    <form action="{{ route('tyc.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="container">      
        <div class="row">
              <div class="form-control">
                <label for="titulo">Título</label><br>
                <div class="col-lg-12">
                  <textarea class="col-lg-12"  id="titulo" name="titulo" placeholder="Aceptación de términos y condiciones">{{ old('titulo') }}</textarea>
                </div>
                  {{ csrf_field() }}
                  @if ($errors->has('titulo'))
                  <small id="linkError" class="form-text text-danger">{{ $errors->first('titulo') }} <!--Se ha producido un error al ingresar el título. --> </small>
                  @endif              
          </div>
      </div>
    </div>

    <div class="container"><br /></div>

      <div class="container">    
      <div class="form-control">            
        <div class="row">  
          
          <div class="col-sm-12">   
          <div class="form-group">     
              <label for="texto1">Texto 1</label><br>               
              <textarea class="form-control"  id="editor" name="texto1" placeholder="Para continuar debe aceptar aquí.">{{ old('texto1') }}</textarea>
            
              {{ csrf_field() }}
              @if ($errors->has('texto1'))
              <small id="linkError" class="form-text text-danger">{{ $errors->first('texto1') }} <!--Se ha producido un error al ingresar el texto. --> </small>
              @endif    
          </div>    
          </div> 


         
         
        </div>  
      </div>  
      </div>

       <div class="container"><br /></div>


       <div class="container">   
       <div class="form-control">             
        <div class="row">            
        <div class="col-sm-12">
        <div class="form-group">   
            <label for="texto2">Texto 2</label><br>
            <div class="col-sm-12">
              <textarea class="col-sm-12"  id="texto2" name="texto2" placeholder="Debe aceptar los siguientes términos condiciones">{{ old('texto2') }}</textarea>
            </div>
              {{ csrf_field() }}
              @if ($errors->has('texto2'))
              <small id="linkError" class="form-text text-danger">{{ $errors->first('texto2') }} <!--Se ha producido un error al ingresar el texto. --> </small>
              @endif                
          </div>
        </div>    
       </div>
       </div>

       <div class="container"><br /></div>

       <div class="container">                
        <div class="row">
           
                <div class="form-control">
                  <label for="texto3">Texto 3</label><br>
                  <div class="col-sm-12">
                    <textarea  class="col-sm-12" id="texto3" name="texto3" placeholder="Acepto los términos y condiciones.">{{ old('texto3') }}</textarea>
                  </div>
                    {{ csrf_field() }}
                    @if ($errors->has('texto3'))
                    <small id="linkError" class="form-text text-danger">{{ $errors->first('texto3') }} <!--Se ha producido un error al ingresar el texto. --> </small>
                    @endif
                </div>
                </div>   
          <table class="table" id="table">
            <tr>
              <th>Pdf</th>
            </tr>
            <tr>
            <td> <input type="file" accept=".pdf" name="inputs[0][pdfNombre]" class="form-control{{ $errors->has('pdf') ? ' is-invalid' : '' }}"onchange="guardarArchivo(this)"></td>
            <td> <button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
            </tr>       
          </table>
            
        
      
       
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="id_cuestionario">Cuestionario</label>
                <select name="id_cuestionario" id="id_cuestionario" class="form-control" >
                    <option value="">Seleccione...</option>
                    @foreach ($cuestionarios as $index => $cuestionario)
                    <option value="{!!$cuestionario->id!!}">{!!$cuestionario->descripcion!!}</option>
                    @endforeach
                </select>
                {{ csrf_field() }}
                @if ($errors->has('id_cuestionario'))
                <small id="linkError" class="form-text text-danger">{{ $errors->first('id_cuestionario') }}</small>
                @endif

            </div>
        </div>


         <!--  <div class="col-sm">
            <div class="form-group">
              <label> Pdf</label>
              <input type="file" name="pdf" class="form-control{{ $errors->has('pdf') ? ' is-invalid' : '' }}">
                @if ($errors->has('file'))
                    <small id="titleError" class="form-text text-danger">{{ $errors->first('pdf') }}</small>
                @endif
            </div>
          </div> -->
          
        </div>
      </div>
          <div class="container">      
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="color">&nbsp;</label><br>
                    <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="estado" name="estado">
                    <label class="form-check-label" for="estado">Activo</label>
                    </div>
                </div>
            </div>
          </div>
       <!--  </div>
      </div> -->
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<style>

  /* Usado para ver indices type hidden (ej: cantidad de líneas) */
.visor {
  width: 1.5rem !important;
  height: 1.5rem !important;
  text-align: center;
  border-radius: 50%;
  border: red 1px solid;
  margin: 1rem;
  /* display: none; */
}
  .btn_agregar {
  
  display: flex;
  justify-content: end;
  gap: 0.5rem;
  margin-top:20px;
  height:50px; 
  weight:50px;
  text-align: center;
  border-style: none;
  }

</style>

<script src={{ asset('ckeditor/ckeditor.js') }}></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>  
  var i=0;
  $('#add').click(function(){    
    i++;       
    $('#table').append(
      `<tr>
        <td><input type="file" name="inputs[`+i+`][pdfNombre]" class="form-control"></td>
        <td><button type="button" name="add" id="add" class="btn btn-danger remove-table-row">Quitar</td>

      </tr>` ) ;

  })
  $(document).on('click','.remove-table-row',function(){
    $(this).parents('tr').remove();
  });


function guardarArchivo(input) {

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


let formData = new FormData();
formData.append('path', input.files[0].name);
formData.append('content', input.files[0]);

$.ajax({

  type: 'POST',
  url: "{{route('guardarArchivo')}}",
  data: formData,
  processData: false,  // tell jQuery not to process the data
  contentType: false,   // tell jQuery not to set contentType

  success: function (respuesta) {
    alertaUpload.addClass('alert-success');
    alertaUpload.children('a').attr('href', respuesta);
  },
  error: function (err) {
    alertaUpload.addClass('alert-danger');
    alertaUpload.children('span').text('No se pudo subir el archivo');
    alertaUpload.children('a').remove();

  }
});

alertaUpload.removeAttr('hidden');

}


/* $( "#btn-restablecer" ).click(function() {
resetRespuestas();
}); */

</script>


@endsection