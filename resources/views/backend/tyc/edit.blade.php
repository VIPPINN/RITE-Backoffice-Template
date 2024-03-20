@extends('backend.app')

@section('content')
<div class="container-fluid px-4">
  <h1 class="mt-4">Editar Términos y Condiciones</h1>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('tyc.index')}}">Inicio</a></li>
      <li class="breadcrumb-item active" aria-current="page">Editar</li>
    </ol>
  </nav>

  @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Verifique los errores marcados.<br><br>
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
    <form action="{{ route('tyc.update', $tyc->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="container">  
        <div class="row">
              <div class="form-control">
                <label for="title">Título</label><br>
                <div class="col-sm-12">
                  <textarea class="col-sm-12"  id="titulo" name="titulo" placeholder="Aceptación de términos y condiciones">{{ $tyc->titulo }}</textarea>
                </div>
                  {{ csrf_field() }}
                  @if ($errors->has('titulo'))
                  <small id="linkError" class="form-text text-danger">{{ $errors->first('titulo') }} <!--Se ha producido un error al ingresar el título. --> </small>
                  @endif              
          </div>
      </div>
    </div></br>    

      <div class="container">                  
        <div class="row">  
        <div class="form-control">  
        <label for="texto1">Texto 1</label><br>       
          
          <div class="col-sm-12">   
          <textarea class="col-sm-12"  id="editor" name="texto1" placeholder="Para continuar debe aceptar aquí.">{{ $tyc->texto1 }}</textarea>
          </div>
            
              {{ csrf_field() }}
              @if ($errors->has('texto1'))
              <small id="linkError" class="form-text text-danger">{{ $errors->first('texto1') }} <!--Se ha producido un error al ingresar el texto. --> </small>
              @endif    
          </div>    
          </div> 


        </div>  
      </div>  
      

       <div class="container">   
       <div class="form-control">             
        <div class="row">            
        <div class="col-sm-12">
        <div class="form-group">   
            <label for="texto2">Texto 2</label><br>
              <textarea class="col-sm-12"  id="texto2" name="texto2" placeholder="Debe aceptar las siguientes condiciones">{{ $tyc->texto2 }}</textarea>
           
              {{ csrf_field() }}
              @if ($errors->has('texto2'))
              <small id="linkError" class="form-text text-danger">{{ $errors->first('texto2') }} <!--Se ha producido un error al ingresar el texto. --> </small>
              @endif                
          </div>
        </div>    
       </div>
       </div></br>
       
      <div class="container">                
        <div class="row">
           
                <div class="form-control">
                  <label for="texto3">Texto 3</label><br>
                  <div class="col-sm-12">
                    <textarea  class="col-sm-12" id="texto3" name="texto3" placeholder="Acepto la Declaración Jurada y doy consentimiento para compartir información.">{{ $tyc->texto3 }}</textarea>
                  </div>
                    {{ csrf_field() }}
                    @if ($errors->has('texto3'))
                    <small id="linkError" class="form-text text-danger">{{ $errors->first('texto3') }} <!--Se ha producido un error al ingresar el texto. --> </small>
                    @endif

                </div>

                <div class="container">
                </div><br>

                @if($tycpdfscant !=0)  
                <div>
                <b>Seleccione para editar:</b>
                </div><br><br>
                
            @foreach($tycpdfs as $index => $tycpdf)
                     
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">   
                          <div> 
                            <input type="checkbox" id="chec_{{$index}}" name="chec_{{$index}}" onchange="comprobar({{$index}});"  >
                            <a href="{{ asset(env('PATH_FILES')) }}/TyCPDFs/{{ $tycpdf->pdfNombre }}"   target="_blank">{{$tycpdf->pdfNombre}}</a>
                            <input  disabled id="btnoriginal_{{$index}}" type="file" name="pdf_{{$index}}" accept="application/pdf" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}" style="width:63.1%;" > 
                          
                            {{ csrf_field() }}
                            @if ($errors->has('name'))
                            <small id="titleError" class="form-text text-danger">Se ha producido un error al ingresar el título.</small>
                            @endif
                        </div><br>
                        </div>
                    </div>
                </div>
            </div>
          @endforeach
          @else
          <div>
           <b> No hay pdf para mostrar</b>
          </div>
          @endif
          <table class="table" id="table">
            <tr>
              <th>Agregar Pdf</th>
            </tr>
            <tr>
            <td> <input type="file" accept=".pdf" name="inputs[0][pdfNombre]" class="form-control{{ $errors->has('pdf') ? ' is-invalid' : '' }}"onchange="guardarArchivo(this)"></td>
            <td> <button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
            </tr>       
          </table>
            
       
       </div>

       <div class="container"><br/></div>
      <div class="container">
        <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="id_cuestionario">Cuestionario</label>
                  <select name="id_cuestionario" id="id_cuestionario" class="form-control" >                   
                    <option value={!! $tyc->idCuestionario !!}>{!!$tyc->descripcionCuestionario!!}</option>
                  </select>
               
                {{ csrf_field() }}
                @if ($errors->has('id_cuestionario'))
                <small id="linkError" class="form-text text-danger">{{ $errors->first('id_cuestionario') }}</small>
                @endif

            </div>
        </div>

      <div class="container"><br/></div>
      <div class="container">
        <div class="row">

         

          <div class="col-sm">
            <div class="form-group">
              <label for="color">&nbsp;</label><br>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" 
                    <?php echo $tyc->estado == 1 ? 'checked' : ''; ?>
                    id="estado" name="estado">
                <label class="form-check-label" for="estado">Activo</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container"><br/></div>
      <div class="container">
        <div class="row">
          <div class="col-sm">
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>




@endsection
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editor.model.schema.extend('$text', { allowAttributes: 'target' });
            editor.model.schema.setAttributeProperties('target', {
                isFormatting: true
            });

            editor.conversion.for('downcast').add(dispatcher => {
                dispatcher.on('attribute', (evt, data, conversionApi) => {
                    if (data.item.name === 'a' && data.attributeKey === 'target') {
                        const element = data.item.getDomNode();
                        element.setAttribute('target', '_blank');
                    }
                });
            });

            editor.conversion.for('upcast').add(dispatcher => {
                dispatcher.on('element:a', (evt, data, conversionApi) => {
                    if (data.reader.hasAttribute('target')) {
                        data.writer.setAttribute('target', '_blank', data.item);
                    }
                });
            });
        })
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


  function comprobar(index)
{ 
    if (document.getElementById("chec_"+index).checked)
      document.getElementById('btnoriginal_'+index).disabled = false;
        
    else
      document.getElementById('btnoriginal_'+index).disabled = true;
        
}
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

  </script>