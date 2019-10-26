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

use App\Trabajo;

Route::get('/', function () {
    $listaTrabajos = Trabajo::all();
    return view('layouts/mainlayout',['listaTrabajos'=>$listaTrabajos]);
})->name('inicio');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home')->middleware('Mailvalidado');

Route::resource('provincia', 'ProvinciaController');

Route::resource('localidad', 'LocalidadController');

Route::resource('rol', 'RolController');

Route::resource('habilidad', 'HabilidadController');

Route::resource('categoriatrabajo', 'CategoriaTrabajoController');

Route::resource('estado', 'EstadoController');

Route::resource('habilidadpersona', 'HabilidadPersonaController');

Route::resource('preferenciapersona', 'PreferenciaPersonaController');

Route::resource('conversacionchat', 'ConversacionChatController');

Route::resource('mensajechat', 'MensajeChatController');




Route::get('postularme/{id}','TrabajoaspiranteController@index')->name('postularme')->middleware('auth','controlperfil');
Route::post('store','TrabajoaspiranteController@store')->name('trabajoaspirante.store')->middleware('auth','controlperfil');

Route::prefix('usuario')->group(function(){
    Route::get('perfil','PersonaController@create')->name('persona.create')->middleware('auth','Mailvalidado');
    Route::get('editar','PersonaController@edit')->name('persona.edit')->middleware('auth','controlperfil');
    Route::post('store','PersonaController@store')->name('persona.store');
    Route::post('update','PersonaController@update')->name('persona.update');
});

Route::get('localidad/buscar/{id}', 'LocalidadController@buscar');

Route::get('veranuncio/{id}', 'TrabajoController@veranuncio')->name('veranuncio');

Route::get('validarMail/{auth}/{id}','UserController@validarMail')->name('validarmail');



Route::prefix('anuncio')->group(function(){
    Route::get('nuevo','TrabajoController@index')->name('trabajo.index')->middleware('auth','controlperfil','controlperfil');
    Route::post('store','TrabajoController@store')->name('trabajo.store');
    Route::get('procesarpago','TrabajoController@procesarpago')->name('trabajo.procesarpago');
    
});