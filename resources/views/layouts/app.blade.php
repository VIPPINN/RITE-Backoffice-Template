<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RITE - Oficina Anticorrupción</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
    <link rel="stylesheet" href={{ asset('css/font-awesome.min.css') }}>
    <link rel="stylesheet" href={{ asset('css/style-rite.css') }}>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <section class="seccion-cabecera-linea01 fixed-top home-nav-color">
    <div class="container">
      <div class="container cabecera-principal">
        <div class="container-fluid row cabecera-principal-contenedor">
            <div class="cabecera-principal-elemento-logo">
              <a href="/">
                <span style="display: inline-block">
                  <img src="{{ asset('images/escudoArg.png')}}" class="cabecera-principal-elemento-logo-escudo" alt="logo" height="35" style="margin-bottom: 1rem;">
                </span><span style="display: inline-block"> <span class="home-text-rite">RITE.gob.ar</span> </span>
              </a>
            </div>
            <div class="cabecera-principal-elemento-buscar">
              {{-- second column --}}
            </div>
        </div>
      </div>
    </div>
  </section>
  
  @yield('menu')
  
  @yield('content')
  
  <section style="background-color: #50535C;">
    <nav class="navbar navbar-expand-md footer-color">
      <div class="container-fluid">
        <div class="container footer-container-width">
          <div class="row" style="width: 100%;">
            <div class="column">
              <p><span class="footer-title" style="line-height: 3rem;">Contacto</span></p>
              <div class="row footer-contact-zone">
                <div class="col-md-12 col-xl-6" style="padding-left: 0">
                  <table>
                    <tr>
                      <td><p style="float: left;"><img src="{{ asset('images/icon-mail.png')}}" /></p></td>
                      <td><p><span class="footer-p-txt"><a href="mailto:contacto@rite.gob.ar">contacto@rite.gob.ar</a></span></p></td>
                    </tr>
                    <tr>
                      <td><p style="float: left; height: 2.4rem"><img src="{{ asset('images/icon-pin.png')}}" alt="logo" height="12"></p></td>
                      <td>
                          <p><span class="footer-p-txt-address">25 de Mayo 544. C.A.B.A<br/>C1002ABL</span></p>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="col-md-12 col-xl-6" style="padding-left: 0">
                  <table>
                    <tr>
                      <td><p><span class="footer-title-social-network">Nuestras redes</span></p></td>
                    </tr>
                    <tr>
                      <td>
                        <p style="float: left; line-height: 2rem;">
                          <a href="http://www.facebook.com/OficinaAnticorrupcion" class="footer-map-link"><img src="{{ asset('images/icon-facebook.png')}}" alt="logo" height="24" style="padding-right: 1rem;"></a>
                          <a href="https://twitter.com/oa_argentina" class="footer-map-link"><img src="{{ asset('images/icon-twitter.png')}}" alt="logo" height="24"  style="padding-right: 1rem;"></a>
                          <a href="http://www.instagram.com/oficinaanticorrupcion" class="footer-map-link"><img src="{{ asset('images/icon-instagram.png')}}" alt="logo" height="24" style="padding-right: 1rem;"></a>
                          <a href="http://www.linkedin.com/company/oficina-anticorrupcion" class="footer-map-link"><img src="{{ asset('images/icon-linkedin.png')}}" alt="logo" height="24"></a>
                        </p>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            {{-- <div class="column">
              <p><span class="footer-title" style="line-height: 4rem;">Mapa del sitio</span></p>
              <div class="row footer-map-heigth">
                <div class="col-md-12 col-xl-6">
                  <p><a href="/" class="footer-map-link">Inicio</a></p>
                  <p><a href="{{ route('about') }}" class="footer-map-link">¿Que es Rite?</a></p>
                </div>
                <div class="col-md-12 col-xl-6">
                  <p><a href="{{ route('novedades') }}" class="footer-map-link">Novedades</a></p>
                  <p><a href="{{ route('herramientas') }}" class="footer-map-link">Caja de Herramientas</a></p>
                </div>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </nav>
    <nav class="navbar navbar-expand-md navbar-dark home-nav-color home-nav-color-footer home-nav-footer-height">
      <div class="container-fluid">
        <div class="container">
            <div class="container">
              <div class="row">
                <div class="logo-oa">
                  <img src="{{ asset('images/logo-oa.png')}}" alt="logo" height="25">
                </div>
                <div class="logo-arg">
                  <span class="home-text-rite">
                    <img src="{{ asset('images/logo-escudo-arg.png')}}" alt="logo" height="26" style="margin-left: 1rem;">
                  </span>
                </div>
                <div class="logo-arg-unida">
                  <img src="{{ asset('images/argentinaUnida.png')}}" alt="logo" height="25" style="margin-left: 1rem;">
                </div>
              </div>
            </div>
        </div>
      </div>
    </nav>
  </section>

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
  
  <script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "210px";
    }
    
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
  </script>

</body>

</html>