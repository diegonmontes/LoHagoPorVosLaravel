<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Auth\RegisterController;

//use Mail;
//use App\Mail\PasswordReset;

class UserController extends Controller

{
    public function register(Request $request){
        //Capturo la clave del usuario
        $plainPassword=$request->claveUsuario;
        $nombreUsuario=$request->nombreUsuario;
        $controller= new Controller;
        $validoNombreUsuario=$controller->moderarTexto($nombreUsuario,1); // 1 Significa que evaluamos la variable terms

        if($validoNombreUsuario){ // Significa que no hay ninguna mala palabra
            //Encripto la clave usuario
            $claveUsuario=bcrypt($request->claveUsuario);
            //Y la agrego al arreglo $request
            $request->request->add(['claveUsuario' => $claveUsuario]);
            //Agrego el rol al usuario que se va a registrar
            //Por defecto el rol sera el 2 'Usuario'
            $request['idRol'] = 2;
            //Busco si existe el mail con lo cual se quieren registrar
            $usuario = User::where('mailUsuario','=',$request->mailUsuario)->get();

            if(count($usuario)<1){
                //Si no exsite creo el usuario y seteo la variable 'success' en true
                $request['auth_key']=str_random(150);
                $objUsuario=User::create($request->all());
                $respuesta = ['success'=>true];
            }else{
                //En caso que exista no creo el usuario y seteo la variable 'success' en false
                $respuesta = ['success'=>false,
                                'error'=>'El mail se encuentra registrado'];
            }
        }else{ // Significa que no puede ingresar ninguna mala palabra
            $respuesta= ['success'=>false,
                        'error'=>'Nombre de usuario indebido. Por favor ingrese otro.'];
        }
      //  print_r($rtaDecode);
        $mail = new EmailController;
        $mail->validarmail($objUsuario);

        return response()->json($respuesta);
    }
    public function crearPerfil(Request $request){
        //Capturo la clave del usuario
        $idUsuario=$request['idUsuario'];
        //Busco si existe una persona para ese usuario
        $personaController = new PersonaController();
        $persona = $personaController->buscar($idUsuario);


        if($persona==null){
            //Si no exsite creo el perfil y seteo la variable 'success' en true
            $personaController->store($request);
            $respuesta = ['success'=>true];
        }else{
            //En caso que exista no creo el usuario y seteo la variable 'success' en false
            $respuesta = ['success'=>false,
                            'error'=>'Ya tiene un perfil creado'];
        }

        //Esto creo que no va
        //$request->request->add(['claveUsuario' => $plainPassword]);


        return response()->json($respuesta);
    }
    public function login(Request $request)
    {
        //Creo un arreglo con las credenciales del usuario
        $credentials = [
            'mailUsuario' => $request->mailUsuario,
            'claveUsuario' => $request->claveUsuario
        ];

        //$input = $request->only('email', 'password');

        //Seteo $jwt_token en null para hacer una comparacion
        $jwt_token = null;
        if (!$jwt_token = auth()->attempt($credentials)) {
            //Si las credenciales son incorrectas la variable 'success' sera false
            //Indicando que los datos ingresados son incorrectos
            return response()->json([
                'success' => false,
                'error' => 'Correo o contraseña incorrectos.',
            ], 401);
        }
        //Obtengo el usuario
        $user = auth::user();

        //busco si ese usuario ya se creo un perfil
        //$request['idUsuario'] = Auth::user()->idUsuario;
        $idUsuario = auth::user()->idUsuario;
//        $persona = Persona::where('idUsuario','=',$request['idUsuario'])->get();
        $personaController = new PersonaController();
        $usuario=['idUsuario'=>$idUsuario];
        $usuario= new Request($usuario);
        $persona = $personaController->buscar($usuario);
        $persona=\json_decode($persona);
        //print_r($persona);
      //  echo $user['email_verified_at'];
        if ($user['email_verified_at']!=null){
            $mailValidado=true;
        } else {
            $mailValidado=false;
        }

        if ($mailValidado){
            return response()->json([
                'success' => true,
                'token' => Str::random(60),
                'user' => $user,
                'idPersona'=>$persona[0]->idPersona,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Debe verificar su mail para poder ingresar.',
            ]);
        }

        
    }



    public function logout(Request $request)
    {
        if(!User::checkToken($request->token)){
            return response()->json([
             'message' => 'Token is required',
             'success' => false,
            ],422);
        }

        try {
            //JWTAuth::invalidate(JWTAuth::parseToken($request));
            auth()->logout();
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }

    }

    public function getCurrentUser(Request $request){
        if(!User::checkToken($request->token)){
            return response()->json([
                'success' => false,
                'message' => 'Token is required'
            ],422);
        }

        $user = JWTAuth::parseToken()->authenticate();
        // add isProfileUpdated....
        $isProfileUpdated=false;
        if($user->isPicUpdated==1 && $user->isEmailUpdated){
            $isProfileUpdated=true;

        }
        $user->isProfileUpdated=$isProfileUpdated;

        return $user;
    }

/*
    public function update(Request $request){
        $user=$this->getCurrentUser($request);
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'User is not found'
            ]);
        }

        unset($data['token']);

        $updatedUser = User::where('id', $user->id)->update($data);
        $user =  User::find($user->id);

        return response()->json([
            'success' => true,
            'message' => 'Information has been updated successfully!',
            'user' =>$user
        ]);
    }
*/

    public function actualizarMail(Request $request){
        $idUsuario = $request->idUsuario;
        $nuevoMail = $request->mailUsuario;
        $claveUsuario = $request->clave;
        $usuario = User::find($idUsuario);

        if(Hash::check($claveUsuario , $usuario->claveUsuario)){
            $existeUsuario = User::where('mailUsuario','=',$nuevoMail)->get();
            if(count($existeUsuario)<1){
                User::find($idUsuario)->update($request->all());
                $respuesta = [
                    'success' => true,
                    'mensaje' => 'Mail actualizado'
                ];
            }else{
                $respuesta = [
                    'success' => false,
                    'mensaje' => 'El mail ya esta en uso. Por favor ingrese otro'
                ];
            }
        }else{
            $respuesta = [
                'success' => false,
                'mensaje' => 'Contraseña incorrecta'
            ];
        }

        return response()->json($respuesta);
    }

    public function actualizarClave(Request $request){
        $idUsuario = $request->idUsuario;
        $claveVieja = $request->claveVieja;
        $claveUsuario = $request->claveNueva;
        $usuario = User::find($idUsuario);
        if(Hash::check($claveVieja , $usuario->claveUsuario)){
            $request['claveUsuario'] = bcrypt($claveUsuario);
            User::find($idUsuario)->update($request->all());
            $respuesta = [
                'success' => true,
                'mensaje' => 'Contraseña actualizada'
            ];
        }else{
            $respuesta = [
                'success' => false,
                'mensaje' => 'Contraseña actual incorrecta'
            ];
        }

        return response()->json($respuesta);

    }

    public function validarMail($auth_key,$id){
        $usuario = User::where('idUsuario','=',$id)->get();
        if(count($usuario) != 0){
            $usuario = $usuario[0];
            if($usuario->auth_key == $auth_key){
                $fechaEmailVerificado = date("Y-m-d H:i:s");
                $usuario->email_verified_at = $fechaEmailVerificado;
                $usuario->auth_key = null;
                $usuario->save();

                return redirect()->route('persona.create')->with('success','Registro satisfactorio de su correo electronico. Ahora completa con tus datos el siguiente formulario.');

            }elseif($usuario->auth_key == null && $usuario->email_verified_at != null){

                return redirect()->route('persona.create')->with('success','Complete el siguiente formulario para poder terminar su perfil.');

            }elseif($usuario->auth_key != $auth_key){

                return redirect()->route('login')->with('success','Hubo un error en la autenticacion de su correo. Intentelo nuevamente mas tarde.');

            }
        }else{
            return redirect()->route('login')->with('success','Usuario inexistente');

        }
    }
    //
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $usuarios=User::orderBy('idUsuario','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('usuario.index',compact('usuarios'));
    }

    public function show($id)
    {
        $usuarios=User::find($id); //Buscamos el elemento para mostrarlo
        return  view('usuario.show',compact('usuarios'));
    }

    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        Usuario::where('idUsuario',$id)->update(['eliminado'=>1]);
     //   User::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('usuario.index')->with('success','Registro eliminado satisfactoriamente');
    }

    public function create()
    {
        $arregloBuscarRoles=['eliminado'=>0];
        $arregloBuscarRoles = new Request($arregloBuscarRoles);
        $rolController = new RolController();
        $listaRoles=$rolController->buscar($arregloBuscarRoles);
        $listaRoles = json_decode($listaRoles);
        return view('usuario.create',['listaRoles'=>$listaRoles]); //Vista para crear el elemento nuevo
    }

    public function store(Request $request)
    {
       
        //Validamos los datos antes de guardar el elemento nuevo
        $this->validate($request,['idRol'=>'required', 'nombreUsuario'=>'required','mailUsuario'=>'required','claveUsuario'=>'required']);
        //Creamos el elemento nuevo
        User::create($request->all());
        return redirect()->route('usuario.index')->with('success','Registro creado satisfactoriamente');
    }

    public function edit($id)
    {
        $arregloBuscarRoles=['eliminado'=>0];
        $arregloBuscarRoles = new Request($arregloBuscarRoles);
        $rolController = new RolController();
        $listaRoles=$rolController->buscar($arregloBuscarRoles);
        $listaRoles = json_decode($listaRoles);
        $usuario=User::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('usuario.edit',compact('usuario'),['listaRoles'=>$listaRoles]);
    }

    public function update(Request $request, $id)
    {
        //Buscamos el usuario
        //Validamos los datos antes de guardar el elemento nuevo
        
        $this->validate($request,['idRol'=>'required', 'nombreUsuario'=>'required','mailUsuario'=>'required','claveUsuario'=>'required']);
        User::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('usuario.index')->with('success','Registro actualizado satisfactoriamente');
    }

    // Esta funcion busca todas los usuarios con parametros que le enviemos
    public function buscar(Request $param){      
        $query = User::OrderBy('idUsuario','ASC'); // Ordenamos los usuarios por este medio

            if (isset($param->idUsuario)){
                $query->where("usuario.idUsuario",$param->idUsuario);
            }

            if (isset($param->nombreUsuario)){
                $query->where("usuario.nombreUsuario",$param->nombreUsuario);
            }

            if (isset($param->mailUsuario)){
                $query->where("usuario.mailUsuario",$param->mailUsuario);
            }

            if (isset($param->auth_key)){
                $query->where("usuario.auth_key",$param->auth_key);
            }

            if (isset($param->claveUsuario)){
                $query->where("usuario.claveUsuario",$param->claveUsuario);
            }

            if (isset($param->email_verified_at)){
                $query->where("usuario.email_verified_at",$param->email_verified_at);
            }

            if (isset($param->idUsuario)){
                $query->where("usuario.idUsuario",$param->idUsuario);
            }

            if (isset($param->idRol)){
                $query->where("usuario.idRol",$param->idRol);
            }

            if (isset($param->remember_token)){
                $query->where("usuario.remember_token",$param->remember_token);
            }

            if (isset($param->eliminado)){
                $query->where("usuario.eliminado",$param->eliminado);
            }
            // Buscamos todos los usuarios que no tengan un perfil
            if (isset($param->usuarioSinPersona)){
                $query->select('usuario.*')
                ->leftJoin('persona', function ($join){
                    $join->on('persona.idUsuario', '=', 'usuario.idUsuario');
                })->whereNull('persona.idUsuario');
            }

            $listaUsuarios= $query->get();   // Hacemos el get y seteamos en lista
            
            return json_encode($listaUsuarios);
    }
    
    

}


