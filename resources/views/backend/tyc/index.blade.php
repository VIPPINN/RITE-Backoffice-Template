@extends('backend.app')

@section('content')

<div class="container-fluid px-4">
  <h1 class="mt-4">Términos y Condiciones</h1>  
  <div class="row mt-3 mb-3">
    <div class="col-sm-4 text-right">
        <a class="btn btn-success" href="{{ route('tyc.create') }}" title="Create a question"> 
            <i class="fas fa-plus-circle"></i>
            AGREGAR TÉRMINOS Y CONDICIONES
        </a>
    </div>
  </div>

   @if ($message = Session::get('success'))
      <script> 

        Swal.fire({
                  position: "center",
                  icon: "success",
                  title: "Acción realizada correctamente",
                  showConfirmButton: false,
                  timer: 2000,
                });
        </script>
  @endif
  <div class="row">
    <table class="table">
      <thead>
        <tr class="btn-primary" >
        
          <th>Id</th>
          <th>Título</th>
          <th>Texto 1</th>
          <th>Texto 2</th>
          <th>Texto 3</th>   
          <th>Cuestionario</th>          
          <th class="text-center ml-2">Status</th>
          <th class="text-center ml-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($tyc as $index => $tycs)
          <tr>
            <th scope="row">
              <span>{{ $loop->index + 1 }}</span>
            </th> 
            <td>
              <span>{!! $tycs->titulo !!}</span>
            </td>
            <td>
              <span>{!! $tycs->texto1 !!}</span>
            </td>
            <td>
              <span>{!! $tycs->texto2 !!}</span>
            </td>
            <td>
              <span>{!! $tycs->texto3 !!}</span>
            </td>
            <td>
              <span>{!! $tycs->descripcionCuestionario !!}</span>
            </td>
         
            <td class="text-center ml-2">
              @if ($tycs->estado == 1)
                <span class='badge bg-success' style='color:White;'>
                  Activo
                </span>
              @else
                <span class='badge bg-danger' style='color:White;'>
                  Inactivo
                </span>
              @endif
            </td>
            <td>
              <span class="text-center ml-2">
                <form id="form_tyc_{{$tycs->id}}" action="{{ route('tyc.destroy', $tycs->id) }}" method="POST">
     
                  <a class="badge bg-info" href="{{ route('tyc.show', $tycs->id) }}"><i class="fas fa-eye"></i> Ver</a>
    
                  <a class="badge bg-warning" href="{{ route('tyc.edit', $tycs->id) }}"><i class="fas fa-edit"></i> Editar</a>
   
                  @csrf
                  @method('DELETE')
      
                  <!--<button type="submit" class="btn btn-danger">Borrar</button> -->
                  <button type="button" onclick="javascript:alertDelete('form_tyc_{{$tycs->id}}')" class="badge bg-danger"><i class="fas fa-edit"></i> Borrar</button>
                </form>
              </span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-sm-4 text-center"> </div>
    <div class="col-sm-4 text-center">
      @isset($tyc)
        {{ $tyc->links('vendor.pagination.custom') }}
      @endisset
    </div>
    <div class="col-sm-4 text-center"> </div>
  </div>


</div>

<script> 

    function alertDelete(form) 
    {
        Swal.fire({
            title: "¿Estas seguro?",
            text: "Este cambio sera permanente!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, borrar!",
        }).then((result) => {
            if (result.value) {
                //si presiona la tecla ok //ajax
                $("#"+ form ).submit();
            } //if
        }); //.them
    }

    function orderFunction(estado) 
    {
        let pathname = "/backend/tyc/filtro/" + estado;
        window.location.href = pathname;
        switch (estado) {
            case 1:
                $("#rbActivo").prop("checked", true);        
                break;
            case 0:
                $("#rbInactivo").prop("checked", true);        
                break;
            case 9:
                $("#rbTodos").prop("checked", true);        
                break;
            default:
                break;
        }
        
    }
</script>

@endsection
<style>
    body{
      background-color: white;
    }
    .container {
      max-width: 1070px !important;
      padding: 0;
     
    }
    .seccion-cabecera-linea01 {
        padding: 0 12px;
    }

    

    .cabecera-principal {
        position: relative;
        max-width: 1175px !important;
        padding: 0.8rem 0;
        height: 72px;
        margin: 0;
    }
    .cabecera-principal-contenedor {
      padding: 0;
      margin: 0;
    }

    .cabecera-principal-elemento-logo {
      width: 50%;
      padding: 0;
    }
    .cabecera-principal-elemento-buscar {
        text-align: right;
        width: 50%;
        padding: 0;
    }

    .header-menu-mobile {
      display: none;
    }
    .home-nav-color-header {
      background-color: #50535C !important;
    }
    .header-container-logo {
        background-color: #37BBED;
        height: 72px;
        padding-top: 1rem;
      }
    .home-nav-header-height {
          height: 72px !important;
        }
    .home-nav-header-height {
          height: 72px !important;
        }
    .header-container-padding {
          /* padding: 2rem 0; */
        }
    .header-logo-oa {
      float: left;
      width: 5%;
      padding-top: 0.4rem;
    }
    .header-logo-txt {
      float: left;
      width: 25%;
    }
    .header-logo-search {
      float: left;
      width: 65%;
      text-align: right;
    }
    .header-nav-responsive {
      display: none;
    }
    .header-first-line {
      max-width: 1175px;
      width: 100%;
    }
    .header-first-line-logo-rite {
      width: 50%;
    }
    .header-first-line-search {
      width: 50%;
    }
    .header-first-line-search-form {
      margin: 0;
    }
    .header-container-width {
      width: 100%;
      max-width: 1175px !important;
      padding: 0;
    }
    .home-nav-footer-height {
      height: 72px !important;
    }
    .column {
      float: left;
      width: 50%;
      padding: 10px;
    }
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    .footer-color {
      background-color: #50535C !important;
    }
    .footer-title {
      font-family: "Encode Sans";
      font-style: normal;
      font-weight: bold;
      font-size: 24px;
      line-height: 30px;
      color: #FFFFFF;
    }
    .footer-p-txt {
      margin-left: 0.5rem;
      font-family: "Encode Sans light";
      font-style: normal;
      font-weight: normal;
      font-size: 16px;
      line-height: 10px;
      display: flex;
      align-items: center;
      color: #FFFFFF;
      text-decoration: none;
    }
    .footer-p-txt a {
      text-decoration: none;
      color: #FFFFFF !important;
    }
    .footer-p-txt a:hover {
      text-decoration: none;
      color: #FFFFFF !important;
    }
    .footer-p-txt-address {
      margin-left: 0.5rem;
      font-family: "Encode Sans light";
      font-style: normal;
      font-weight: normal;
      font-size: 16px;
      line-height: 25px;
      display: flex;
      align-items: center;
      color: #FFFFFF;
    }
    .footer-title-social-network {
      font-family: "Encode Sans";
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 10px;
      color: #FFFFFF;
    }
    .footer-map-link {
      font-family: "Encode Sans";
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 10px;
      color: #FFFFFF;
      text-decoration: none;
    }
    .footer-map-link:hover {
      color:rgba(255, 255, 255, 1);
    }
    .has-search .form-control {
        padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    .home-input-search {
      background: #7DCFED;
      border: 1px solid #FFFFFF;
      box-sizing: border-box;
      border-radius: 6px;
      height: 2.5rem;
      width: 16.5rem;
    }
    
    input[id="search-txt"]::placeholder {
      font-family: "Encode Sans light";
      font-style: normal;
      font-weight: normal;
      font-size: 16px;
      line-height: 24px;
      display: flex;
      align-items: center;
      color: #F3F3F3;
      opacity: 0.75;
    }
    .search1200 {
      display: none;
    }
    .footer-contact-zone {
      padding: 0 0.7rem;
      max-width: 1175px !important;
    }
    .footer-container-logo {
      /* padding: 0.5rem; */
    }
    .fa {
      font-size: 19px !important;
    }
    .logo-oa {
      float: left;
      margin-top: 0.8rem !important;
      width: 15%;
    }
    .logo-arg {
      margin-top:12.8px;
      float: left;
      width: 25%;
    }
    .logo-arg-unida {
      float: left;
      width: 60%;
      margin-top: 0.8rem !important;
      text-align: right;
    }
    .footer-container-padding {
      /* padding: 2rem 0; */
    }

    @media only screen and (max-width:1175px) {
      .home-nav-color-header {
      background-color: #50535C !important;
    }

    .home-text-rite{
      font-size: 25.5667px;
      line-height: 32px;
    }

    .cabecera-principal{
      height: 56px;
    }

    .cabecera-principal {
        padding-top: 0.8rem;
        padding-bottom: 0.8rem;
        padding-right: 12px;
    }

    .search-txt {
      padding-left: 0 !important;
    }
    
.home-nav-header-height {
      height: 72px !important;
    }
.home-nav-header-height {
      height: 72px !important;
    }
.header-container-padding {
      padding: 0;
    }
.header-logo-oa {
      float: left;
      width: 5%;
      padding-top: 0.4rem;
    }
    .header-logo-txt {
      float: left;
      width: 25%;
    }
    .header-logo-search {
      float: left;
      width: 70%;
      text-align: right;
    }

      .header-container-width {
        width: 100%;
        max-width: 1175px;
      }
      .footer-container-width{
        width: 100%;
        padding: 0 1rem;
        max-width: 1175px;
      }
      .footer-map-heigth p{
        padding: 0 0 1rem 0;
      }
      .home-nav-color-footer {
        background-color: #50535C !important;
      }
      .footer-container-logo {
        background-color: #37BBED;
        height: 72px;
        padding-top: 1.5rem;
      }
      .footer-contact-zone {
        padding: 0 0.7rem;
      }
      
      /* Search component */
      .search-box {
        position : relative;
        top : 1rem;
        left : 50%;
        transform : translate(-50%,-50%);
        background : #37BBED;
        height : 40px;
        border-radius : 40px;
      }
      .search-btn {
        color : white;
        float : right;
        width : 40px;
        height : 40px;
        border-radius: 50%;
        background : #37BBED;
        display:flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        transition:0.4s;
      }
      .search-txt {
        margin-right: 20px;
        border:none;
        outline:none;
        float:left;
        padding:0;
        color: #37BBED;
        font-size:16px;
        transition : 0.4s;
        line-height: 40px;
        width : 0px;
      }
     /* .search-box:hover > .search-txt  {
        width: 240px;
        padding: 0 6px;
        color: #FFFFFF;
      } */
      .search-box:hover > .search-btn {
        background: white;
        color: #37BBED;
      }
      .search888 {
        display: none !important;
      }

      .search-box:hover > .search-txt  {
        width: 11rem;
        padding: 0 6px;
        color: #FFFFFF;
        background-color: #7DCFED;
        position:absolute;
        /*margin-left: -13.5rem; */
        margin-left: -11.5rem;
        border: 1px solid white;
      }
      
      input[id="search-txt"]::placeholder {
        font-family: "Encode Sans light";
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 24px;
        display: flex;
        align-items: center;
        color: #F3F3F3;
        opacity: 0.75;
      }
      .container {
        max-width: 888px;
      }
      .footer-container-padding {
        padding: 0;
      }
      .home-nav-color-footer {
        background-color: #37BBED !important;
      }
      
    }
    @media only screen and (max-width:887px) {

      .container {
        max-width: 875px !important;
        margin: 0;
      }
      .menu-movil-titulo {
        font-family: "Encode Sans" !important;
        font-style: normal !important;
        font-weight: bold !important;
        font-size: 16px !important;
        line-height: 24px !important;
        text-align: left !important;
        color: #50535C !important;
      }
      .menu-movil-activo {
        background-color: #37BBED;
        color: #FFFFFF !important;
      }
      .cabecera-principal {
        padding: 0.8rem 0;
      }
      .header-logo-oa {
      float: left;
      width: 5%;
      padding-top: 0.4rem;
      }
      .header-logo-txt {
        float: left;
        width: 35%;
      }
      .header-logo-search {
        float: left;
        width: 55%;
        text-align: right;
        margin: 0.4rem 0;
      }
      .header-nav-responsive {
        display: inline-block;
        position: relative;
        top: -0.8rem;
      }
      .header-navbar-toggler {
        color: rgba(255, 255, 255, 1);
        border: 0;
        background-color: transparent;
        height: 32px;
        width: 32px;
        margin-top: 0.5rem;
        text-align: right;
      }

      .search-btn {
        height: 40px !important;
      }

      .header-container-logo {
        height: 64px;
        padding-top: 0.5rem;
      }
      .cabecera-principal-elemento-logo-escudo {
        margin-bottom: 0.6rem !important;
      }
      .home-text-rite {
        font-size: 1.3rem;
        margin-left: 0;
      }

      .search-box:hover > .search-txt  {
        width: 11rem;
        padding: 0 6px;
        color: #FFFFFF;
        background-color: #7DCFED;
        position:absolute;
        /*margin-left: -13.5rem; */
        margin-left: -11.5rem;
        border: 1px solid white;
      }
      
      input[id="search-txt"]::placeholder {
        font-family: "Encode Sans light";
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 24px;
        display: flex;
        align-items: center;
        color: #F3F3F3;
        opacity: 0.75;
      }

      .header-first-line-search-form {
        margin: 0.4rem 0;
      }
      .home-card-que-rite {
        width: 47rem;
      }
      .column {
        width: 100%;
      }
      .home-nav-color-footer {
        background-color: #37BBED !important;
      }  
      .logo-oa {
        width: 100%;
        margin-top: 0.8rem !important;
        padding: 1rem;
      }
      .logo-arg {
        width: 100%;
        padding: 1rem 0;
      }
      .logo-arg-unida {
        width: 100%;
        padding: 1rem 0;
        margin-top: 0.8rem !important;
        text-align: left;
      }
      .footer-container-padding {
        padding: 0;
      }
      .footer-container-logo {
        padding-top: 0;
        height: 170px;
      }
      .home-nav-footer-height {
        height: 210px !important;
      }

      .preguntas header {
        margin-top: 2rem;
      }

      .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        right: 0;
        background-color: white;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
      }

      .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-family: "Encode Sans";
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 24px;
        color: #37BBED;
        display: block;
        transition: 0.3s;
        text-align: left;
      }

      .sidenav a:hover {
        /*color: #f1f1f1; */ 
        color: #808285;
      }

      .sidenav .closebtn {
        position: absolute;
        top: 10px;
        font-size: 36px;
        margin-left: 8rem;
      }
      
    }

    
    
  </style>