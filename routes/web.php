<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitialController;
use App\Http\Controllers\backend\HomeController;
use App\Http\Controllers\backend\HomeSliderController;
use App\Http\Controllers\backend\HomeVideoController;
use App\Http\Controllers\backend\HomeNewsController;
use App\Http\Controllers\backend\HomeTyCController;
use App\Http\Controllers\backend\LogActivityController;
use App\Http\Controllers\backend\AboutController;
use App\Http\Controllers\backend\FAQController;
use App\Http\Controllers\backend\HomeRedesController;
use App\Http\Controllers\NovedadesController;
use App\Http\Controllers\backend\CitasController;
use App\Http\Controllers\backend\RegistrarseController;
use App\Http\Controllers\backend\HomeRiteNumerosController;
use App\Http\Controllers\backend\HomeSostenibleController;
use App\Http\Controllers\backend\HomeContenidoAboutController;
use App\Http\Controllers\backend\RiteNumerosController;

use App\Http\Controllers\backend\TipoRecursoController;
use App\Http\Controllers\backend\OrientadoRecursoController;
use App\Http\Controllers\backend\OrigenRecursoController;
use App\Http\Controllers\backend\RecursoController;
use App\Http\Controllers\backend\TemaRecursoController;



use App\Http\Controllers\backend\NivelController;
use App\Http\Controllers\backend\TipoPreguntaController;
use App\Http\Controllers\backend\ComunidadController;




use App\Http\Controllers\backend\NuevoCuestionarioController;
use App\Http\Controllers\backend\HomeCuestionarioVersionController;

use App\Http\Controllers\backend\HomeGrupoEntidadController;
use App\Http\Controllers\backend\HomeCategoriaEntidadController;
use App\Http\Controllers\backend\HomeActividadEntidadController;
use App\Http\Controllers\backend\HomeTipoEntidadController;
//usuarios y delegacion
use App\Http\Controllers\backend\HomeUsuariosController;
use App\Http\Controllers\backend\HomeBuscarUsuarioController;
use App\Http\Controllers\backend\HomeEmpresasController;
use App\Http\Controllers\backend\HomeDelegarController;
//caja de herramientas dinamico
use App\Http\Controllers\backend\HomeHerramientaTipoController;
use App\Http\Controllers\backend\HomeHerramientaController;
//Notificaciones
use App\Http\Controllers\backend\HomeNotificacionesEnviadasController;
use App\Http\Controllers\backend\HomeNotificacionesRecibidasController;
//Rango de ventas para entidades
use App\Http\Controllers\backend\RangoVentasController;

//Permisos y roles
use App\Http\Controllers\backend\PermisosController;
use App\Http\Controllers\backend\RolController;

//Usuarios API
use App\Http\Controllers\backend\HomeUsuariosApiController;
use App\Http\Controllers\HomeDescargasExcelController;


//Filter Package
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [InitialController::class, 'index']);

Auth::routes();

/* Route::get('/register', function() { return redirect('/login'); });
Route::post('/register', function() { return redirect('/login'); }); */

Route::group(['middleware' => 'auth'], function () {
  Route::prefix('backend')->group(function () {
    // ==== Log Activity ====//
    Route::get('add-to-log', [LogActivityController::class, 'index']);
    Route::get('view-log', [LogActivityController::class, 'index'])->name('log');

    // ==== Statics contents ====//
    Route::get('home', [HomeController::class, 'index'])->name('home');

    // ==== Sliders ====//
    Route::resource('sliders', HomeSliderController::class);
    Route::get('sliders/filtro/{estado}', [HomeSliderController::class, 'filtro'])->name('filtro-Carrusel');

    // ==== FAQs ====//
    Route::resource('faqs', FAQController::class);
    Route::get('faqs/filtro/{estado}', [FAQController::class, 'filtro'])->name('filtro-PreguntaFrecuente');
    // ==== Videos ====//
    Route::resource('videos', HomeVideoController::class);
    Route::get('videos/filtro/{estado}', [HomeVideoController::class, 'filtro'])->name('filtro-Video');

    // ==== Quote ==== //
    Route::resource('citas', CitasController::class);

    // ==== Por Que Registrarse ==== //
    Route::resource('registrarse', RegistrarseController::class);

    // ==== Rite En numeros Home ====//
    Route::resource('riteNumeros', HomeRiteNumerosController::class);

    // ==== RITE en números pantalla ==== //
    Route::get('estadisticas/', [RiteNumerosController::class, 'riteNumerosIndex'])->name('riteNumerosIndex');
    Route::get('estadisticas/crear', [RiteNumerosController::class, 'agregarEstadistica'])->name('agregarEstadistica');
    Route::post('estadisticas/guardar', [RiteNumerosController::class, 'guardarEstadistica'])->name('guardarEstadistica');
    Route::get('estadisticas/editar/{id}', [RiteNumerosController::class, 'editarEstadistica'])->name('editarEstadistica');
    Route::post('estadisticas/actualizar/{id}', [RiteNumerosController::class, 'actualizarEstadistica'])->name('actualizarEstadistica');

    // ==== Sostenible ====//
    Route::get('sostenible/', [HomeSostenibleController::class, 'index'])->name('sostenible');
    Route::get('sostenible/crear', [HomeSostenibleController::class, 'crear'])->name('crearSostenible');
    Route::post('sostenible/guardar', [HomeSostenibleController::class, 'guardar'])->name('guardarSostenible');
    Route::get('sostenible/editar/{id}', [HomeSostenibleController::class, 'editar'])->name('editarSostenible');
    Route::post('sostenible/actualizar/{id}', [HomeSostenibleController::class, 'actualizar'])->name('actualizarSostenible');
    Route::delete('sostenible/delete/{id}', [HomeSostenibleController::class, 'destroySostenible'])->name('sostenible-destroy');
    // ==== Sostenible Cuestioanrios====//
    Route::get('sostenible-cuestionarios/{id}', [HomeSostenibleController::class, 'indexSostenibleCuestionarios'])->name('sostenible-cuestionarios');
    Route::get('sostenible-cuestionarios/crear-cuestionarios/{id}', [HomeSostenibleController::class, 'crearSostenibleCuestionarios'])->name('sostenible-cuestionarios-crear');
    Route::post('sostenible-cuestionarios/store-cuestionarios/{id}', [HomeSostenibleController::class, 'storeSostenibleCuestionarios'])->name('sostenible-cuestionarios-store');
    Route::get('sostenible-cuestionarios/editar-cuestionarios/{id}', [HomeSostenibleController::class, 'editarSostenibleCuestionarios'])->name('sostenible-cuestionarios-edit');
    Route::put('sostenible-cuestionarios/update-cuestionarios/{id}', [HomeSostenibleController::class, 'updateSostenibleCuestionarios'])->name('sostenible-cuestionarios-update');
    
    // ==== Contenido About ====//
    Route::get('registro/', [HomeContenidoAboutController::class, 'registro'])->name('registro');
    Route::get('registro/crear', [HomeContenidoAboutController::class, 'crearRegistro'])->name('crearRegistro');
    Route::post('registro/guardar', [HomeContenidoAboutController::class, 'guardarRegistro'])->name('guardarRegistro');
    Route::get('registro/editar/{id}', [HomeContenidoAboutController::class, 'editarRegistro'])->name('editarRegistro');
    Route::post('registro/update/{id}', [HomeContenidoAboutController::class, 'actualizarRegistro'])->name('actualizarRegistro');
    Route::get('contenido/', [HomeContenidoAboutController::class, 'index'])->name('contenido');
    Route::get('contenido/crear', [HomeContenidoAboutController::class, 'crear'])->name('crearContenido');
    Route::post('contenido/guardar', [HomeContenidoAboutController::class, 'guardar'])->name('guardarContenido');
    Route::get('contenido/editar/{id}', [HomeContenidoAboutController::class, 'editar'])->name('editarContenido');
    Route::post('contenido/actualizar/{id}', [HomeContenidoAboutController::class, 'actualizar'])->name('actualizarContenido');
    Route::delete('contenido/delete/{id}', [HomeContenidoAboutController::class, 'destroyContenido'])->name('contenido-destroy');
   

    // ==== Comunidad ==== //
    Route::get('comunidad/', [ComunidadController::class, 'comunidadIndex'])->name('comunidadIndex');
    Route::get('comunidad/create', [ComunidadController::class, 'comunidadCreate'])->name('comunidadCreate');
    Route::post('comunidad/store', [ComunidadController::class, 'comunidadStore'])->name('comunidadStore');
    Route::get('comunidad/edit/{id}', [ComunidadController::class, 'comunidadEditar'])->name('comunidadEditar');
    Route::post('comunidad/update/{id}', [ComunidadController::class, 'comunidadUpdate'])->name('comunidadUpdate');

    Route::get('agenda/', [ComunidadController::class, 'agendaIndex'])->name('agendaIndex');
    Route::get('agenda/create', [ComunidadController::class, 'agendaCreate'])->name('agendaCreate');
    Route::post('agenda/store', [ComunidadController::class, 'agendaStore'])->name('agendaStore');
    Route::get('agenda/edit/{id}', [ComunidadController::class, 'agendaEditar'])->name('agendaEditar');
    Route::post('agenda/update/{id}', [ComunidadController::class, 'agendaUpdate'])->name('agendaUpdate');


    Route::get('formacion/', [ComunidadController::class, 'formacionIndex'])->name('formacionIndex');
    Route::get('formacion/create', [ComunidadController::class, 'formacionCreate'])->name('formacionCreate');
    Route::post('formacion/store', [ComunidadController::class, 'formacionStore'])->name('formacionStore');
    Route::get('formacion/edit/{id}', [ComunidadController::class, 'formacionEditar'])->name('formacionEditar');
    Route::post('formacion/update/{id}', [ComunidadController::class, 'formacionUpdate'])->name('formacionUpdate');

    Route::get('acuerdos/', [ComunidadController::class, 'acuerdosIndex'])->name('acuerdosIndex');
    Route::get('acuerdos/create', [ComunidadController::class, 'acuerdosCreate'])->name('acuerdosCreate');
    Route::post('acuerdos/store', [ComunidadController::class, 'acuerdosStore'])->name('acuerdosStore');
    Route::get('acuerdos/edit/{id}', [ComunidadController::class, 'acuerdosEditar'])->name('acuerdosEditar');
    Route::post('acuerdos/update/{id}', [ComunidadController::class, 'acuerdosUpdate'])->name('acuerdosUpdate');


    // ==== Noticias ====//
    Route::resource('news', HomeNewsController::class);
    Route::get('news/filtro/{estado}', [HomeNewsController::class, 'filtro'])->name('filtro-Novedades');

    // ==== Terminos y Condiciones ====//
    Route::resource('tyc', HomeTyCController::class);
    // Route::get('tyc/filtro/{estado}', [HomeTyCController::class, 'filtro'])->name('filtro-TyC');
    Route::post('tyc/guardarArchivo', [HomeTyCController::class, 'guardarArchivo'])->name('guardarArchivo');

    // ==== About ==== //
    Route::resource('about', AboutController::class);
    Route::get('about/filtro/{estado}', [AboutController::class, 'filtro'])->name('filtro-QueEsRite');

    // ==== Redes Sociales ==== //
    Route::resource('redes', HomeRedesController::class);
    Route::get('redes/filtro/{estado}', [HomeRedesController::class, 'filtro'])->name('filtro-Redes');

    // === Recurso === //
    Route::resource('recurso', RecursoController::class);
    Route::get('recurso/filtro/{estado}', [RecursoController::class, 'filtro'])->name('filtro-Recurso');

    // === Tipo Recurso === //
    Route::resource('tipoRecurso', TipoRecursoController::class);
    Route::get('tipoRecurso/filtro/{estado}', [TipoRecursoController::class, 'filtro'])->name('filtro-tipo-Recurso');

    // === Orientado Recurso === //
    Route::resource('orientadoRecurso', OrientadoRecursoController::class);
    Route::get('orientadoRecurso/filtro/{estado}', [OrientadoRecursoController::class, 'filtro'])->name('filtro-orientado-Recurso');

    // === Origen Recurso === //
    Route::resource('origenRecurso', OrigenRecursoController::class);
    Route::get('origenRecurso/filtro/{estado}', [OrigenRecursoController::class, 'filtro'])->name('filtro-origen-Recurso');

    // === Tema Recurso === //
    Route::resource('temaRecurso', TemaRecursoController::class);
    Route::get('temaRecurso/filtro/{estado}', [TemaRecursoController::class, 'filtro'])->name('filtro-tema-Recurso');

    //##############################################################
    // ====== Caja de Herramientas =============//

    // Tipos de Herramientas
    Route::resource('herramientaTipo', HomeHerramientaTipoController::class);

    /*Herramientas de Ciudadania*/
    Route::get('herramienta/ciudadania', [HomeHerramientaController::class, 'ciudadaniaIndex'])->name('ciudadania');
    Route::get('herramienta/ciudadania/crear', [HomeHerramientaController::class, 'ciudadaniaCrear'])->name('ciudadaniaCrear');
    Route::post('herramienta/ciudadania/guardar', [HomeHerramientaController::class, 'ciudadaniaGuardar'])->name('ciudadaniaGuardar');
    Route::get('herramienta/ciudadania/editar/{id}', [HomeHerramientaController::class, 'ciudadaniaEditar'])->name('ciudadaniaEditar');
    Route::post('herramienta/ciudadania/update/{id}', [HomeHerramientaController::class, 'ciudadaniaUpdate'])->name('ciudadaniaUpdate');
    Route::post('herramienta/ciudadania/delete/{id}', [HomeHerramientaController::class, 'ciudadaniaBorrar'])->name('ciudadaniaBorrar');

    /*Herramientas de Empresa*/
    Route::get('herramienta/empresa', [HomeHerramientaController::class, 'empresaIndex'])->name('empresa');
    Route::get('herramienta/empresa/crear', [HomeHerramientaController::class, 'empresaHerramientaCrear'])->name('empresaHerramientaCrear');
    Route::post('herramienta/empresa/guardar', [HomeHerramientaController::class, 'empresaHerramientaGuardar'])->name('empresaHerramientaGuardar');
    Route::get('herramienta/empresa/formularios', [HomeHerramientaController::class, 'empresaHerramientaListado'])->name('empresaHerramientaListado');
    Route::get('herramienta/empresa/formularios/crear', [HomeHerramientaController::class, 'empresaForularioCrear'])->name('empresaForularioCrear');
    Route::post('herramienta/empresa/formularios/guardar', [HomeHerramientaController::class, 'formularioEmpresaGuardar'])->name('formularioEmpresaGuardar');
    Route::get('herramienta/empresa/editar/{id}', [HomeHerramientaController::class, 'empresaHerramientaEditar'])->name('empresaHerramientaEditar');
    Route::post('herramienta/empresa/update/{id}', [HomeHerramientaController::class, 'empresaHerramientaUpdate'])->name('empresaHerramientaUpdate');
    Route::post('herramienta/empresa/delete/{id}', [HomeHerramientaController::class, 'empresaHerramientaBorrar'])->name('empresaHerramientaBorrar');
    Route::get('herramienta/empresaFormulario/editar/{id}', [HomeHerramientaController::class, 'empresaFormularioEditar'])->name('empresaFormularioEditar');
    Route::post('herramienta/empresaFormulario/update/{id}', [HomeHerramientaController::class, 'formularioEmpresaUpdate'])->name('formularioEmpresaUpdate');
    
    /*Herramientas de Entidad*/    
    Route::get('herramienta/entidad', [HomeHerramientaController::class, 'entidadIndex'])->name('entidad');
    Route::get('herramienta/entidad/crear', [HomeHerramientaController::class, 'entidadHerramientaCrear'])->name('entidadHerramientaCrear');
    Route::post('herramienta/entidad/guardar', [HomeHerramientaController::class, 'entidadHerramientaGuardar'])->name('entidadHerramientaGuardar');
    Route::get('herramienta/entidad/formularios', [HomeHerramientaController::class, 'entidadHerramientaListado'])->name('entidadHerramientaListado');
    Route::get('herramienta/entidad/formularios/crear', [HomeHerramientaController::class, 'entidadForularioCrear'])->name('entidadForularioCrear');
    Route::post('herramienta/entidad/formularios/guardar', [HomeHerramientaController::class, 'formularioEntidadGuardar'])->name('formularioEntidadGuardar');
    Route::get('herramienta/entidad/editar/{id}', [HomeHerramientaController::class, 'entidadHerramientaEditar'])->name('entidadHerramientaEditar');
    Route::post('herramienta/entidad/update/{id}', [HomeHerramientaController::class, 'entidadHerramientaUpdate'])->name('entidadHerramientaUpdate');
    Route::post('herramienta/entidad/delete/{id}', [HomeHerramientaController::class, 'entidadHerramientaBorrar'])->name('entidadHerramientaBorrar');
    Route::get('herramienta/entidadFormulario/editar/{id}', [HomeHerramientaController::class, 'entidadFormularioEditar'])->name('entidadFormularioEditar');
    Route::post('herramienta/entidadFormulario/update/{id}', [HomeHerramientaController::class, 'formularioEntidadUpdate'])->name('formularioEntidadUpdate');

    //############################################################
    // ==== Preguntas ==== //


    // ==== Nivel ==== //
    Route::resource('nivel', NivelController::class);


    // ==== Tipo Pregunta ==== //
    Route::resource('tipoPregunta', TipoPreguntaController::class);



    //############################################################

    //###############################################################
    // ==== Cuestionario ==== //
    //Route::resource('cuestionarios', HomeCuestionarioController::class); 
    // ==== Cuestionario Versión ==== //
    //Route::resource('cuestionarioVersion', HomeCuestionarioVersionController::class);
    //##################################################################################


    //NUEVO CUESTIONARIO

    Route::get('cuestionarios/crear', [NuevoCuestionarioController::class, 'crearCuestionario'])->name('cuestionario-create');
    Route::post('cuestionarios/guardar', [NuevoCuestionarioController::class, 'guardarCuestionario'])->name('cuestionario-store');
    Route::post('cuestionarios/delete/{id}', [NuevoCuestionarioController::class, 'destroyCuestionario'])->name('cuestionario-destroy');

    Route::resource('nuevoCuestionario', NuevoCuestionarioController::class);

    Route::get('cuestionarios/', [NuevoCuestionarioController::class, 'versiones'])->name('versiones');
    Route::get('cuestionarios/crearVersion/{id}', [NuevoCuestionarioController::class, 'crearVersion'])->name('version-create');
    Route::post('cuestionarios/guardarVersion', [NuevoCuestionarioController::class, 'guardarVersion'])->name('version-store');
    Route::get('cuestionarios/editarVersion/{id}', [NuevoCuestionarioController::class, 'editarVersion'])->name('version-edit');
    Route::post('cuestionarios/editarVersion', [NuevoCuestionarioController::class, 'editarVersionSave'])->name('version-editSave');
    Route::post('cuestionarios/deleteversion/{id}', [NuevoCuestionarioController::class, 'destroyCuestionarioVersion'])->name('version-destroy');


    Route::get('cuestionarios/crearTema/{id}', [NuevoCuestionarioController::class, 'crearTema'])->name('tema-create');
    Route::post('cuestionarios/guardarTema', [NuevoCuestionarioController::class, 'guardarTema'])->name('tema-store');
    Route::get('cuestionarios/editarTema/{id}', [NuevoCuestionarioController::class, 'editarTema'])->name('tema-edit');
    Route::post('cuestionarios/editarTema', [NuevoCuestionarioController::class, 'editarTemaSave'])->name('tema-editSave');
    Route::post('cuestionarios/deleteTema/{id}', [NuevoCuestionarioController::class, 'destroyTema'])->name('tema-destroy');

    //Route::get('cuestionarios/preguntas', [NuevoCuestionarioController::class, 'versiones'])->name('versiones'); 
    Route::get('cuestionarios/crearPregunta/{id}', [NuevoCuestionarioController::class, 'crearPregunta'])->name('pregunta-create');
    Route::post('cuestionarios/guardarPregunta', [NuevoCuestionarioController::class, 'guardarPregunta'])->name('pregunta-store');
    Route::get('cuestionarios/editarPregunta/{id}', [NuevoCuestionarioController::class, 'editarPregunta'])->name('pregunta-edit');
    Route::post('cuestionarios/editarPregunta', [NuevoCuestionarioController::class, 'editarPreguntaSave'])->name('pregunta-editSave');
    Route::post('cuestionarios/deletePregunta/{id}', [NuevoCuestionarioController::class, 'destroyPregunta'])->name('pregunta-destroy');


    Route::get('cuestionarios/crearOpcion/{id}', [NuevoCuestionarioController::class, 'crearOpcion'])->name('opcion-create');
    Route::post('cuestionarios/guardarOpcion', [NuevoCuestionarioController::class, 'guardarOpcion'])->name('opcion-store');
    Route::get('cuestionarios/editarOpcion/{id}', [NuevoCuestionarioController::class, 'editarOpcion'])->name('opcion-edit');
    Route::post('cuestionarios/editarOpcion', [NuevoCuestionarioController::class, 'editarOpcionSave'])->name('opcion-editSave');
    Route::post('cuestionarios/deleteOpcion/{id}', [NuevoCuestionarioController::class, 'destroyOpcion'])->name('opcion-destroy');

    Route::get('cuestionarios/crearOpcionImpacta/{id}', [NuevoCuestionarioController::class, 'crearOpcionImpacta'])->name('opcionImpacta-create');
    Route::post('cuestionarios/guardarOpcionImpacta', [NuevoCuestionarioController::class, 'guardarOpcionImpacta'])->name('opcionImpacta-store');
    Route::get('cuestionarios/editarOpcionImpacta/{id}', [NuevoCuestionarioController::class, 'editarOpcionImpacta'])->name('opcionImpacta-edit');
    Route::post('cuestionarios/editarOpcionImpacta', [NuevoCuestionarioController::class, 'editarOpcionImpactaSave'])->name('opcionImpacta-editSave');
    Route::post('cuestionarios/deleteOpcionImpacta/{id}', [NuevoCuestionarioController::class, 'destroyOpcionImpacta'])->name('opcionImpacta-destroy');


    Route::get('cuestionarios', [NuevoCuestionarioController::class, 'index'])->name('cuestionarios');
    Route::get('cuestionarios/{id}', [NuevoCuestionarioController::class, 'versiones'])->name('versiones-show');
    Route::get('cuestionarios/temas/{id}', [NuevoCuestionarioController::class, 'temas'])->name('temas-show');
    Route::get('cuestionarios/temas/preguntas/{id}', [NuevoCuestionarioController::class, 'preguntas'])->name('preguntas-show');
    Route::get('cuestionarios/temas/preguntas/opciones/{id}', [NuevoCuestionarioController::class, 'opciones'])->name('opciones-show');
    Route::get('cuestionarios/temas/preguntas/opcionesImpactan/{id}', [NuevoCuestionarioController::class, 'opcionesImpactan'])->name('opcionesImpactan-show');



    //#################################################################################
    // ==== GRUPOS ENTIDAD ==== //
    Route::resource('gruposEntidad', HomeGrupoEntidadController::class);
    // ==== CATEGORÎA ENTIDAD ==== //
    Route::resource('categoriasEntidad', HomeCategoriaEntidadController::class);
    // ==== ACTIVIDAD ENTIDAD ==== //
    Route::resource('actividadEntidad', HomeActividadEntidadController::class);
    // ==== ACTIVIDAD ENTIDAD ==== //
    Route::resource('tipoEntidad', HomeTipoEntidadController::class);
    //###############################################################################

    // ==== USUARIOS ==== //
    Route::resource('usuarios', HomeUsuariosController::class);
    Route::resource('empresas', HomeEmpresasController::class);
    Route::resource('delegar', HomeDelegarController::class);
    Route::post('/backend/usuarios/habilitar/{id}', [HomeUsuariosController::class, 'habilitar'])->name('usuarios.habilitar');
    Route::post('/backend/empresas/habilitar/{id}', [HomeEmpresasController::class, 'habilitar'])->name('empresas.habilitar');
    Route::get('/backend/usuarios/buscar', [HomeBuscarUsuarioController::class, 'indexUsuario'])->name('usuarios.buscar');
    Route::get('/backend/empresas/buscar', [HomeBuscarUsuarioController::class, 'indexEmpresa'])->name('empresas.buscar');
    Route::get('/backend/delegar/buscar', [HomeBuscarUsuarioController::class, 'indexDelegar'])->name('delegar.buscar');

    /* Route::get('usuarios/filtro/{estado}', [HomeUsuariosController::class, 'filtro'])->name('filtro-Usuarios'); */

    // ==== USUARIOS API ==== //
    Route::resource('usuarios_api', HomeUsuariosApiController::class);

    Route::get('/giveAccess', [HomeUsuariosApiController::class, 'giveAccess'])->name('usuarios_api.giveAccess');
    Route::post('/saveAccess', [HomeUsuariosApiController::class, 'saveAccess'])->name('usuarios_api.cargarAcceso');
    Route::post('/usuarios_api/revoke/{id}', [HomeUsuariosApiController::class, 'revokeAccess'])->name('usuarios_api.revoke');
    Route::post('/usuarios_api/activate/{id}', [HomeUsuariosApiController::class, 'activateAccess'])->name('usuarios_api.activate');

     // ==== DESCARGAS EXCEL ==== //
     Route::get('/descargas', [HomeDescargasExcelController::class, 'index'])->name('descargasExcel');
     Route::get('/descargas-1', [HomeDescargasExcelController::class, 'listadoEmpresas'])->name('listadoEmpresas');
     Route::get('/descargas-2', [HomeDescargasExcelController::class, 'cantidadxGrupo'])->name('cantidadxGrupo');
     Route::get('/descargas-3', [HomeDescargasExcelController::class, 'cantidadxActividad'])->name('cantidadxActividad');
     Route::get('/descargas-4', [HomeDescargasExcelController::class, 'usuariosExport'])->name('usuariosExport');
     Route::get('/descargas-5', [HomeDescargasExcelController::class, 'cantidadxCategoria'])->name('cantidadxCategoria');
     Route::get('/descargas-6', [HomeDescargasExcelController::class, 'cantidadxJurisdiccion'])->name('cantidadxJurisdiccion');
     Route::get('/descargas-7', [HomeDescargasExcelController::class, 'descargarRespuestas'])->name('descargarRespuestas');

    // ==== EMPRESAS ==== //
    Route::get('empresas/filtro/{estado}', [HomeEmpresasController::class, 'filtro'])->name('filtro-Empresas');

    // ==== NOTIFICACIONES ==== //
    Route::resource('notificacionEnviada', HomeNotificacionesEnviadasController::class);
    Route::resource('notificacionRecibida', HomeNotificacionesRecibidasController::class);

    // ==== Permisos y Roles ==== //
    Route::resource('permisos', PermisosController::class);
    Route::resource('roles', RolController::class);
    // ==== RANGO DE VENTAS PARA ENTDADES ==== //
    Route::resource('rangos', RangoVentasController::class);
  });
});
