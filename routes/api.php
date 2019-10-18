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




/** APIs de Persona */
Route::post('crearPerfil', 'PersonaController@store');
Route::post('perfil', 'PersonaController@getCurrentPerfil');
Route::post('actualizarPerfil', 'PersonaController@actualizarPerfil');


//API actualizar perfil y usuario */actualizarPerfil

/** APIs de Trabajo persona */
Route::post('storeTrabajo','TrabajoController@store');
Route::post('listarTrabajos','TrabajoController@buscarTrabajos');
Route::post('detalleTrabajo','TrabajoController@buscarTrabajoParam');

/** APIs de Categoria trabajo */
Route::get('listarCategorias','CategoriaTrabajoController@buscarCategorias');

/** APIs de Provincias */
Route::post('listarProvincias','ProvinciaController@buscarProvincias');


/** APIs de Localidad */
Route::post('listarLocalidades','LocalidadController@buscarLocalidades');
Route::post('listarTrabajos','TrabajoController@buscarTrabajos');
Route::post('detalleTrabajo','TrabajoController@buscarTrabajoParam');
Route::post('datosMP', 'MercadoPagoController@crearPago');
