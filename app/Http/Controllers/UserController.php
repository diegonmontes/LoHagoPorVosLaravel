<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
//use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

//use Mail;
//use App\Mail\PasswordReset;

class UserController extends Controller
{
    public function register(Request $request){
        $plainPassword=$request->claveUsuario;
        $claveUsuario=bcrypt($request->claveUsuario);
        $request->request->add(['claveUsuario' => $claveUsuario]);
        // create the user account
        $request['idRol'] = 2;
        $created=User::create($request->all());

        $request->request->add(['claveUsuario' => $plainPassword]);
        // login now..
        return response()->json([
            'success' => true,
        ]);
        //return $this->login($request);
    }
    public function login(Request $request)
    {

        $jwt_token = null;
        $user = User::where('mailUsuario','=',$request['mailUsuario'])->get();
        if($user <> null){
            $var=[
                'success' => true,
                'token' => $jwt_token,
                'user' => $user
            ];
        }else{
            $var=[
                'success' => false,
                'token' => $jwt_token,
                'user' => null
            ];
        }
        

        return response()->json($var);
    }
    public function logout(Request $request)
    {
        if(!User::checkToken($request)){
            return response()->json([
                'message' => 'Token is required',
                'success' => false,
            ],422);
        }

        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
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
        if(!User::checkToken($request)){
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


