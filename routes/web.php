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
use App\Persona;
use App\Provincia;
use App\Habilidad;
use App\CategoriaTrabajo;
use App\Http\Controllers\UserController;



use Illuminate\Http\Request;

use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\PersonaController;

Broadcast::routes();


//Si esta logeado mostramos todos los anuncios que no sean de la persona logeada
Route::get('/', function () {
    if (Auth::check()){
        //Buscamos la persona logeada, para ello primero seteamos el id del usuario logeado
        $idUsuario = Auth::user()->idUsuario;
        //Con el idUsuario buscamos la persona
        $controlPersona = new PersonaController;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $controlPersona->buscar($param);
        $persona = json_decode($persona);
        //Si tiene la persona creada descartamos sus anuncios, en caso contrario lo mandamos a crear el perfil
        if(count($persona)<1){
            //Seteamos las variables para mostrar la pagina de crear el perfil
            $persona = new Persona;
            $existePersona = false;
            $listaHabilidadesSeleccionadas = null;
            $listaPreferenciasSeleccionadas = null;
            $provincias=Provincia::all();
            $habilidades=Habilidad::all();
            $categoriasTrabajo=CategoriaTrabajo::all();
            $idUsuario = Auth::user()->idUsuario;
            //Buscamos el usuario
            $usuarioController = new UserController;
            $paramBuscarUsuario = ['idUsuario'=>$idUsuario, 'eliminado'=>0];
            $paramBuscarUsuario = new Request($paramBuscarUsuario);
            $usuario = $usuarioController->buscar($paramBuscarUsuario);
            $usuario = json_decode($usuario);
            $usuario = $usuario[0];
            $pagina = view('persona.create',compact('persona'),['provincias'=>$provincias,'categoriasTrabajo'=>$categoriasTrabajo,'habilidades'=>$habilidades, 'existePersona'=>$existePersona,'listaHabilidadesSeleccionadas'=>$listaHabilidadesSeleccionadas,'listaPreferenciasSeleccionadas'=>$listaPreferenciasSeleccionadas,'usuario'=>$usuario]);
        }else{
            //Si tiene el perfil creado buscamos los anuncios para mostrar
            $idPersona = $persona[0]->idPersona;
            $param=['idPersonaDistinto'=>$idPersona,'eliminado'=>0,'idEstado'=>1];
            $trabajoController = new TrabajoController();
            $param = new Request($param);
            //$listaTrabajos =$trabajoController->buscar($param);
            $listaTrabajos =$trabajoController->ordenarTrabajosInicio($param);
            $listaTrabajos = json_decode($listaTrabajos);
            $categoriaTrabajo = new CategoriaTrabajo;
            $busqueda = false;
            $pagina = view('layouts/mainlayout',['listaTrabajos'=>$listaTrabajos,'categoriaTrabajo'=>$categoriaTrabajo, 'busqueda'=>$busqueda]);

        }
    }else{
        //El el caso que no esta autenticado mostramos todos los anuncios
        $param=['idEstado'=>'1','eliminado'=>0];
        $trabajoController = new TrabajoController();
        $param = new Request($param);
        $listaTrabajos =$trabajoController->buscar($param);
        $listaTrabajos = json_decode($listaTrabajos);
        $categoriaTrabajo = new CategoriaTrabajo;
        $busqueda = false;
        $pagina = view('layouts/mainlayout',['listaTrabajos'=>$listaTrabajos,'categoriaTrabajo'=>$categoriaTrabajo, 'busqueda'=>$busqueda]);
    }
    return $pagina;
})->name('inicio');
    

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home')->middleware('Mailvalidado');

Route::prefix('administrador')->middleware('auth','role:1')->group(function(){
    Route::resource('rol', 'RolController');
    Route::resource('provincia', 'ProvinciaController');

    Route::resource('localidad', 'LocalidadController');
    
    Route::resource('habilidad', 'HabilidadController')->middleware('auth', 'role:1');;
    
    Route::resource('categoriatrabajo', 'CategoriaTrabajoController');
    
    Route::resource('estado', 'EstadoController');
    
    Route::resource('habilidadpersona', 'HabilidadPersonaController');
    
    Route::resource('preferenciapersona', 'PreferenciaPersonaController');
    
    Route::resource('conversacionchat', 'ConversacionChatController');
    
    Route::resource('mensajechat', 'MensajeChatController');
    
    Route::resource('estadotrabajo', 'EstadotrabajoController');
    
    Route::post('pagorecibido/storepanel','PagorecibidoController@storepanel')->name('pagorecibido.storepanel');
    
    Route::resource('pagorecibido', 'PagorecibidoController');
    
    Route::resource('trabajoasignado', 'TrabajoasignadoController');
    Route::post('valoracion/storepanel','ValoracionController@storepanel')->name('valoracion.storepanel');
    
    Route::resource('valoracion', 'ValoracionController');
    
    Route::resource('comentario', 'ComentarioController');
    
    Route::get('persona/createpanel','PersonaController@createpanel')->name('persona.createpanel');
    
    Route::post('persona/storepanel','PersonaController@storepanel')->name('persona.storepanel');
    
    Route::post('persona/updatepanel','PersonaController@updatepanel')->name('persona.updatepanel');
    
    Route::resource('persona', 'PersonaController');
    
    Route::get('trabajo/indexpanel','TrabajoController@indexpanel')->name('trabajo.indexpanel');
    
    Route::get('trabajo/createpanel','TrabajoController@createpanel')->name('trabajo.createpanel');
    
    Route::post('trabajo/storepanel','TrabajoController@storepanel')->name('trabajo.storepanel');
    
    Route::post('trabajo/updatepanel','TrabajoController@updatepanel')->name('trabajo.updatepanel');
    
    Route::resource('trabajo', 'TrabajoController');
    
    Route::get('trabajoaspirante/indexpanel','TrabajoaspiranteController@indexpanel')->name('trabajoaspirante.indexpanel');
    
    Route::get('trabajoaspirante/createpanel','TrabajoaspiranteController@createpanel')->name('trabajoaspirante.createpanel');
    
    Route::post('trabajoaspirante/storepanel','TrabajoaspiranteController@storepanel')->name('trabajoaspirante.storepanel');
    
    Route::post('trabajoaspirante/updatepanel','TrabajoaspiranteController@updatepanel')->name('trabajoaspirante.updatepanel');
    
    Route::resource('trabajoaspirante', 'TrabajoaspiranteController');

    Route::get('multa/indexpanel','MultaController@indexpanel')->name('multa.indexpanel');
    
    Route::get('multa/createpanel','MultaController@createpanel')->name('multa.createpanel');
    
    Route::post('multa/storepanel','MultaController@storepanel')->name('multa.storepanel');

    Route::resource('multa', 'MultaController');
    
    
});

Route::get('/chat', 'MensajeChatController@indexDos');
Route::post('messages', 'MensajeChatController@fetch')->middleware('auth');
Route::post('enviarmensaje', 'MensajeChatController@sentMessage')->middleware('auth');




Route::post('store','TrabajoasignadoController@store')->name('trabajoasignado.store')->middleware('auth','Mailvalidado','controlperfil');

Route::prefix('usuario')->group(function(){
    Route::get('perfil','PersonaController@create')->name('persona.create')->middleware('auth','Mailvalidado');
    Route::get('editar','PersonaController@edit')->name('persona.edit')->middleware('auth','controlperfil');
    Route::post('store','PersonaController@store')->name('persona.store');
    Route::post('update','PersonaController@update')->name('persona.update');
});

Route::get('localidad/buscarporid/{id}', 'LocalidadController@buscarporid');
Route::get('mispostulaciones', 'TrabajoController@mispostulaciones')->name('mispostulaciones')->middleware('auth','Mailvalidado','controlperfil');

Route::get('historial', 'TrabajoController@historial')->name('historial')->middleware('auth','Mailvalidado','controlperfil');


Route::get('veranuncio/{idTrabajo}', 'TrabajoController@veranuncio')->name('veranuncio')->middleware('auth','Mailvalidado','controlperfil');
Route::get('trabajorealizado/{idTrabajo}', 'TrabajoController@trabajorealizado')->name('trabajorealizado')->middleware('auth','Mailvalidado','controlperfil');
Route::post('terminado', 'ValoracionController@store')->name('valoracion.enviarvaloracion')->middleware('auth','Mailvalidado','controlperfil');
Route::get('valorar/{idTrabajo}', 'TrabajoController@valor')->name('trabajo.valor')->middleware('auth','Mailvalidado','controlperfil');
Route::post('valorarpersona', 'ValoracionController@valorarpersona')->name('trabajo.valorarpersona')->middleware('auth','Mailvalidado','controlperfil');
Route::get('cancelar/{idTrabajo}', 'TrabajoController@cancelartrabajo')->name('trabajo.cancelartrabajo')->middleware('auth','Mailvalidado','controlperfil');
Route::post('multa.cancelartrabajo', 'MultaController@cancelartrabajo')->name('multa.cancelartrabajo')->middleware('auth','Mailvalidado','controlperfil');



Route::post('comentario', 'ComentarioController@store')->name('comentario.store')->middleware('auth','Mailvalidado','controlperfil');
Route::get('postularme/{id}','TrabajoaspiranteController@index')->name('postularme')->middleware('auth','controlperfil');
Route::post('store','TrabajoaspiranteController@store')->name('trabajoaspirante.store')->middleware('auth','controlperfil');

Route::get('postulantes/{id}','TrabajoController@postulantes')->name('anuncio.postulante')->middleware('auth','controlperfil');


Route::get('validarMail/{auth}/{id}','UserController@validarMail')->name('validarmail');

Route::prefix('anuncio')->group(function(){
    Route::get('nuevo','TrabajoController@index')->name('trabajo.index')->middleware('auth','controlperfil','Mailvalidado');
    Route::post('store','TrabajoController@store')->name('trabajo.store');
    Route::get('procesarpago','TrabajoController@procesarpago')->name('trabajo.procesarpago'); 

});

Route::get('persona/{id}/editpanel','PersonaController@editpanel')->name('persona.editpanel');
Route::get('trabajo/{id}/editpanel','TrabajoController@editpanel')->name('trabajo.editpanel');
Route::get('trabajoaspirante/{id}/editpanel','TrabajoaspiranteController@editpanel')->name('trabajoaspirante.editpanel');

Route::resource('usuario', 'UserController');

Route::post('actualizar', 'UserController@actualizarUsuario')->name('actualizar')->middleware('auth','controlperfil','Mailvalidado');

Route::post('actualizarClaveNueva', 'UserController@actualizarClaveNueva')->name('actualizarClaveNueva')->middleware('auth','controlperfil','Mailvalidado');

Route::get('conversaciones', 'ConversacionChatController@misconversaciones')->name('conversaciones')->middleware('auth','Mailvalidado','controlperfil');

Route::post('chat', 'ConversacionChatController@miChat')->name('chat')->middleware('auth','Mailvalidado','controlperfil');

Route::get('buscar', 'TrabajoController@filtrar')->name('buscar');

Route::get('actualizarvisto','MensajeChatController@actualizarvisto')->name('mensajechat.actualizarvisto')->middleware('auth');
