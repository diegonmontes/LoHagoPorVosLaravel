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


Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::post('crearPerfil', 'UserController@crearPerfil');
Route::get('user', 'UserController@getCurrentUser');
Route::post('update', 'UserController@update');
Route::get('logout', 'UserController@logout');
Route::post('storeTrabajo','TrabajoController@storeApp');
Route::get('listarCategorias','CategoriaTrabajoController@buscarCategorias');
Route::post('listarProvincias','ProvinciaController@buscarProvincias');
Route::post('listarLocalidades','LocalidadController@buscarLocalidades');
Route::post('listarTrabajos','TrabajoController@buscarTrabajos');
