<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** APIs de Usuario */
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::post('update', 'UserController@update');
Route::get('logout', 'UserController@logout');
Route::get('user', 'UserController@getCurrentUser');
Route::post('actualizarMail', 'UserController@actualizarMail');
Route::post('actualizarClave', 'UserController@actualizarClave');


/** APIs de Persona */
Route::post('crearPerfil', 'PersonaController@store');
Route::post('perfil', 'PersonaController@getCurrentPerfil');
Route::post('actualizarPerfil', 'PersonaController@actualizarPerfil');
Route::post('datosPersona', 'PersonaController@buscar');


//API actualizar perfil y usuario */actualizarPerfil

/** APIs de Trabajo persona */
Route::post('storeTrabajo','TrabajoController@store');
Route::post('listarTrabajosInicio','TrabajoController@ordenarTrabajosInicio');
Route::post('detalleTrabajo','TrabajoController@buscarTrabajoParam');
Route::post('historialTrabajos','TrabajoController@buscar');
Route::post('buscarComentarios','ComentarioController@buscarComentarios');
Route::post('guardarComentario','ComentarioController@store');
Route::post('misTrabajosFinalizados','TrabajoController@misTrabajosFinalizados');
Route::post('buscarPersonaTrabajo','TrabajoController@buscarPersonaTrabajo');
Route::post('listarTrabajosBusqueda','TrabajoController@buscar');
Route::get('listarFiltros','TrabajoController@datosFiltrarFlutter');
Route::post('cancelarTrabajo','MultaController@cancelarTrabajo');




/** Trabajo Aspirantes */
Route::post('listarAspirantesTrabajo','TrabajoaspiranteController@buscarTrabajoAspirante');
Route::post('buscarAspiranteTrabajo','TrabajoaspiranteController@buscar');
Route::post('misPostulaciones','TrabajoaspiranteController@misPostulaciones');

/** Trabajo Asignado */
Route::post('elegirAspirante','TrabajoasignadoController@store');
Route::post('buscarTrabajoAsingado','TrabajoasignadoController@buscar');
Route::post('misAsignaciones','TrabajoasignadoController@misAsignaciones');


/** PAGOS */
Route::post('buscarPagoTrabajo','PagorecibidoController@buscar');

/** APIs de Categoria trabajo */
Route::get('listarCategorias','CategoriaTrabajoController@buscarCategorias');

/** APIs de Provincias */
Route::get('listarProvincias','ProvinciaController@buscarProvincias');

/** APIs de Habilidades */
Route::get('listarHabilidades','HabilidadController@buscarHabilidades');


/** APIs de Localidad */
Route::post('listarLocalidades','LocalidadController@buscarLocalidades');
Route::post('datosLocalidad','LocalidadController@buscarNuevo');
Route::post('detalleTrabajo','TrabajoController@buscarTrabajoParam');
Route::post('datosMP', 'MercadoPagoController@crearPago');


/** CHAT */
Route::get('listarMensajes','MensajeChatController@buscarMensajes');
Route::post('guardarMensaje','MensajeChatController@store');
Route::post('listarMensajesConversacion','MensajeChatController@listarMensajesConversacion');
Route::post('listarConversaciones','ConversacionChatController@listarConversacionesFlutter');
Route::post('actualizarvisto','ConversacionChatController@actualizarvisto');
Route::post('buscarConversaciones','ConversacionChatController@buscar');




/** POSTULACIONES */
Route::post('postularme','TrabajoaspiranteController@store');

/** VALORACION */
Route::post('enviarValoracion','ValoracionController@store');
Route::post('buscarValoracionTrabajo','ValoracionController@buscar');
Route::post('buscarDatosPostulacion','TrabajoasignadoController@buscarDatosPostulacion');
Route::post('promedioValoraciones','ValoracionController@promedioValoraciones');

