<?php

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

Route::get('/', function () {
    return view('layouts/mainlayout');
})->name('inicio');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('provincia', 'ProvinciaController');

Route::resource('localidad', 'LocalidadController');

Route::resource('rol', 'RolController');

//Route::resource('persona', 'PersonaController');

//Route::get('persona/create', 'UserProfileController@create')->name('profile');
Route::prefix('usuario')->group(function(){
    Route::get('perfil','PersonaController@create')->name('persona.create')->middleware('auth');
    Route::get('editar','PersonaController@edit')->name('persona.edit')->middleware('auth');
    Route::get('store','PersonaController@store')->name('persona.store');
    Route::get('update','PersonaController@update')->name('persona.update');
});

Route::get('localidad/buscar/{id}', 'LocalidadController@buscar');

Route::prefix('anuncio')->group(function(){
    Route::get('nuevo','TrabajoController@index')->name('trabajo.index')->middleware('auth');
    Route::get('store','TrabajoController@store')->name('trabajo.store');
});


