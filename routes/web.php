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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('provincia', 'ProvinciaController');

Route::resource('localidad', 'LocalidadController');

Route::resource('rol', 'RolController');

Route::resource('categoriatrabajo', 'CategoriaTrabajoController');

Route::resource('estado', 'EstadoController');




Route::get('postularme/{id}','TrabajoaspirantesController@index')->name('postularme')->middleware('auth','controlperfil');
Route::post('store','TrabajoaspirantesController@store')->name('trabajoaspirantes.store')->middleware('auth','controlperfil');

Route::prefix('usuario')->group(function(){
    Route::get('perfil','PersonaController@create')->name('persona.create')->middleware('auth');
    Route::get('editar','PersonaController@edit')->name('persona.edit')->middleware('auth');
    Route::post('store','PersonaController@store')->name('persona.store');
    Route::get('update','PersonaController@update')->name('persona.update');
});

Route::get('localidad/buscar/{id}', 'LocalidadController@buscar');

Route::get('veranuncio/{id}', 'TrabajoController@veranuncio')->name('veranuncio');





Route::prefix('anuncio')->group(function(){
    Route::get('nuevo','TrabajoController@index')->name('trabajo.index')->middleware('auth','controlperfil');
    Route::post('store','TrabajoController@store')->name('trabajo.store');
    Route::get('procesarpago','TrabajoController@procesarpago')->name('trabajo.procesarpago');
    
});


