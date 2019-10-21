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
                User::create($request->all());
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
        $persona = $personaController->buscar($idUsuario);

        return response()->json([
            'success' => true,
            'token' => Str::random(60),
            'user' => $user,
            'idPersona'=>$persona['idPersona'],

        ]);
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

}


