<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>RITE - Backend</title>
    <link href="{{ asset('backend/css/simple-datatables.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/css/style-backend.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/js/font-awesome-all.min.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.numeric.min.js') }}"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('home') }}">Backoffice</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            {{-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> --}}
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('log') }}">Actividad</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                            {{ __('Salir') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="{{ route('home') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Escritorio
                        </a>
                        <div class="sb-sidenav-menu-heading">Textos</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsInicio" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Inicio
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsInicio" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-sliders" class="nav-link" href="{{ route('sliders.index') }}">Inicio
                                    Slider</a>
                                <a id="url-videos" class="nav-link" href="{{ route('videos.index') }}">Video
                                    Presentación</a>
                                <a id="url-news" class="nav-link" href="{{ route('news.index') }}">Novedades</a>
                                <a id="url-redes" class="nav-link" href="{{ route('redes.index') }}">Redes Sociales</a>
                                <a id="url-citas" class="nav-link" href="{{ route('citas.index') }}">Card Citas</a>
                                <a id="url-citas" class="nav-link" href="{{ route('registrarse.index') }}">Card
                                    Registrarse</a>
                                <a id="url-citas" class="nav-link" href="{{ route('riteNumeros.index') }}">Card
                                    Estadísticas</a>
                                <a id="url-citas" class="nav-link" href="{{ route('sostenible') }}">Card Integridad
                                    Sostenible</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsQueEsRite" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            About
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsQueEsRite" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-about" class="nav-link" href="{{ route('about.index') }}">About</a>
                                <a id="url-faqs" class="nav-link" href="{{ route('contenido') }}">Contenido</a>
                                <a id="url-faqs" class="nav-link" href="{{ route('faqs.index') }}">Preguntas
                                    Frecuentes</a>
                                <a id="url-faqs" class="nav-link" href="{{ route('registro') }}">Como
                                    Registrarse</a>

                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsCajaDeHerramientas" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Caja de Herramientas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsCajaDeHerramientas" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-recursos" class="nav-link"
                                    href="{{ route('herramientaTipo.index') }}">Herramienta Tipo</a>
                                <a id="url-recurso-tipo" class="nav-link"
                                    href="{{ route('ciudadania') }}">Herramienta Ciudadania</a>
                                <a id="url-recurso-tipo" class="nav-link" href="{{ route('empresa') }}">Herramienta
                                    Empresa</a>
                                <a id="url-recurso-tipo" class="nav-link" href="{{ route('entidad') }}">Herramienta
                                    Entidad</a>

                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsNovedades" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Novedades
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsNovedades" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-news" class="nav-link" href="{{ route('news.index') }}">Novedades</a>
                            </nav>
                        </div>
                        <!--======================== TERMINOS Y CONDICIONES ======================================= -->

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsTyCs" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Términos y Condiciones
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsTyCs" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-tyc" class="nav-link" href="{{ route('tyc.index') }}">Términos y
                                    Condiciones</a>
                            </nav>
                        </div>

                        <!-- Rite en numeros -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsRITENumeros" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Estadísticas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsRITENumeros" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-rite-numeros" class="nav-link"
                                    href="{{ route('riteNumerosIndex') }}">Estadísticas</a>
                            </nav>
                        </div>
                        <!--======================== COMUNIDAD ======================================= -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayoutsComunidad" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Comunidad
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsComunidad" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-rite-numeros" class="nav-link"
                                    href="{{ route('comunidadIndex') }}">Comunidad</a>
                            </nav>
                        </div>
                        <div class="collapse" id="collapseLayoutsComunidad" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-rite-numeros" class="nav-link"
                                    href="{{ route('agendaIndex') }}">Agenda</a>
                            </nav>
                        </div>
                        <div class="collapse" id="collapseLayoutsComunidad" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-rite-numeros" class="nav-link"
                                    href="{{ route('formacionIndex') }}">Formación</a>
                            </nav>
                        </div>
                        <div class="collapse" id="collapseLayoutsComunidad" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-rite-numeros" class="nav-link"
                                    href="{{ route('acuerdosIndex') }}">Acuerdos</a>
                            </nav>
                        </div>

                        <!--======================== PREGUNTAS ======================================= -->
                        <div class="sb-sidenav-menu-heading">Preguntas</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_preguntas" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Preguntas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_preguntas" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-nivel" class="nav-link" href="{{ route('nivel.index') }}">Nivel</a>
                                <a id="url-tipoPregunta" class="nav-link"
                                    href="{{ route('tipoPregunta.index') }}">Tipo de Preguntas</a>

                            </nav>
                        </div>

                        <!--======================== CUESTIONARIO ======================================= -->
                        <div class="sb-sidenav-menu-heading">Cuestionario</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_cuestionarios" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Cuestionarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_cuestionarios" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-cuestionario" class="nav-link"
                                    href="{{ route('cuestionarios') }}">Cuestionario</a>

                            </nav>
                        </div>


                        <!--======================== CLASIFICACIÓN ======================================= -->
                        <div class="sb-sidenav-menu-heading">Clasificación</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_clasificacion" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Clasificación
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_clasificacion" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('actividadEntidad.index') }}">Actividad Entidad</a>
                                <a id="url-categoriasEntidad" class="nav-link"
                                    href="{{ route('categoriasEntidad.index') }}">Categoría Entidad</a>
                                <a id="url-gruposEntidad" class="nav-link"
                                    href="{{ route('gruposEntidad.index') }}">Grupo Entidad</a>
                                <a id="url-tipoEntidad" class="nav-link"
                                    href="{{ route('tipoEntidad.index') }}">Tipo Entidad</a>
                            </nav>
                        </div>

                        <!--======================== USUARIOS ======================================= -->
                        <div class="sb-sidenav-menu-heading">Empresas Pioneras</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_usuarios" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Usuarios
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_usuarios" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('usuarios.index') }}">Usuarios</a>
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('empresas.index') }}">Empresas</a>
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('delegar.index') }}">Delegar</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_roles" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Permisos y Roles
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_roles" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('roles.index') }}">Roles</a>
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('permisos.index') }}">Permisos</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_rangoVentas" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Entidad
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_rangoVentas" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('rangos.index') }}">Rango de Ventas</a>
                            </nav>
                        </div>

                        <!--======================== USUARIOS API======================================= -->
                        <div class="sb-sidenav-menu-heading">API</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_usuariosapi" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Usuarios API
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_usuariosapi" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('usuarios_api.index') }}">Usuarios API</a>

                            </nav>
                        </div>

                        <!--======================== DESCARGAS EXCEL ======================================= -->
                        <div class="sb-sidenav-menu-heading">Descargas</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_descargasExcel" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Descargas Excel
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_descargasExcel" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="descargasExcel" class="nav-link"
                                    href="{{ route('descargasExcel') }}">Descargas</a>

                            </nav>
                        </div>

                        <!--======================== NOTIFICACION ======================================= -->
                        <div class="sb-sidenav-menu-heading">Notificación</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts_notificacion" aria-expanded="false"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Notificación
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts_notificacion" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('notificacionEnviada.index') }}">Notificaciones Enviadas</a>
                                <a id="url-actividadEntidad" class="nav-link"
                                    href="{{ route('notificacionRecibida.index') }}">Notificaciones Recibidas</a>
                            </nav>
                        </div>


                    </div>



                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Bienvenido:</div>
                    {{ Auth::user()->name }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted"></div>
                        <div>Copyright &copy; {{ env('APP_HEADER') }}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('backend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/js/Chart.min.js') }}"></script>
    <script src="{{ asset('backend/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('backend/assets/demo/chart-bar-demo.js') }}"></script>
    <script src="{{ asset('backend/js/simple-datatables.js') }}"></script>
    <script src="{{ asset('backend/js/datatables-simple-demo.js') }}"></script>
</body>

<script>
    let url = window.location.pathname;
    if (url.indexOf("about") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-about").addClass("active")
    };
    if (url.indexOf("faqs") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-faqs").addClass("active")
    };
    if (url.indexOf("sliders") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-sliders").addClass("active")
    };
    if (url.indexOf("videos") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-videos").addClass("active")
    };
    if (url.indexOf("news") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-news").addClass("active")
    };
    if (url.indexOf("tyc") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-tyc").addClass("active")
    };
    if (url.indexOf("RITENumeros") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-rite-numeros").addClass("active")
    };
    if (url.indexOf("redes") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-redes").addClass("active")
    };
    if (url.indexOf("recurso") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-recursos").addClass("active")
    };
    if (url.indexOf("tipoRecurso") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-recurso-tipo").addClass("active")
    };
    if (url.indexOf("orientadoRecurso") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-recurso-orientado").addClass("active")
    };
    if (url.indexOf("origenRecurso") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-recurso-origen").addClass("active")
    };
    if (url.indexOf("temaRecurso") !== -1) {
        $("#collapseLayouts").addClass("show");
        $("#url-recurso-tema").addClass("active")
    };

    if (url.indexOf("nivel") !== -1) {
        $("#collapseLayouts_preguntas").addClass("show");
        $("#url-nivel").addClass("active")
    };
    if (url.indexOf("preguntas") !== -1) {
        $("#collapseLayouts_preguntas").addClass("show");
        $("#url-preguntas").addClass("active")
    };
    if (url.indexOf("preguntaOpcion") !== -1) {
        $("#collapseLayouts_preguntas").addClass("show");
        $("#url-preguntaOpcion").addClass("active")
    };
    if (url.indexOf("preguntaNivel") !== -1) {
        $("#collapseLayouts_preguntas").addClass("show");
        $("#url-preguntaNivel").addClass("active")
    };
    if (url.indexOf("tema") !== -1) {
        $("#collapseLayouts_preguntas").addClass("show");
        $("#url-tema").addClass("active")
    };
    if (url.indexOf("tipoPregunta") !== -1) {
        $("#collapseLayouts_preguntas").addClass("show");
        $("#url-tipoPregunta").addClass("active")
    };

    if (url.indexOf("cuestionario") !== -1) {
        $("#collapseLayouts_cuestionarios").addClass("show");
        $("#url-cuestionario").addClass("active")
    };
    if (url.indexOf("cuestionarioVersion") !== -1) {
        $("#collapseLayouts_cuestionarios").addClass("show");
        $("#url-cuestionarioVersion").addClass("active")
    };

    if (url.indexOf("actividadEntidad") !== -1) {
        $("#collapseLayouts_clasificacion").addClass("show");
        $("#url-actividadEntidad").addClass("active")
    };
    if (url.indexOf("categoriasEntidad") !== -1) {
        $("#collapseLayouts_clasificacion").addClass("show");
        $("#url-categoriasEntidad").addClass("active")
    };
    if (url.indexOf("gruposEntidad") !== -1) {
        $("#collapseLayouts_clasificacion").addClass("show");
        $("#url-gruposEntidad").addClass("active")
    };
    if (url.indexOf("tipoEntidad") !== -1) {
        $("#collapseLayouts_clasificacion").addClass("show");
        $("#url-tipoEntidad").addClass("active")
    };
</script>

</html>
