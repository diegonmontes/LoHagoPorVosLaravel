<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
//use JWTAuth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;
//use Tymon\JWTAuth\JWTAuth;
use JWTAuth;
use Illuminate\Support\Facades\Validator;


//use Mail;
//use App\Mail\PasswordReset;

class UserController extends Controller
{
    public function register(Request $request){
        //Capturo la clave del usuario
        $plainPassword=$request->claveUsuario;
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
        $user = Auth::user();

        //busco si ese usuario ya se creo un perfil
        //$request['idUsuario'] = Auth::user()->idUsuario;
        $idUsuario = Auth::user()->idUsuario;
//        $persona = Persona::where('idUsuario','=',$request['idUsuario'])->get();
        $personaController = new PersonaController();
        $persona = $personaController->buscar($idUsuario);

        return response()->json([
            'success' => true,
            'token' => Str::random(60),
            'user' => $user,
            'persona'=>$persona['idPersona'],
            
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



}


