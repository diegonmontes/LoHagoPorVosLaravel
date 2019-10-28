<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\EmailController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $mensajesErrores =[
            'nombreUsuario.max' => 'Limite de caracteres sobrepasado.',
            'nombreUsuario.required' => 'El nombre de usuario es obligatorio.',
            'mailUsuario.unique' => 'El mail ya se encuentra registrado.',
            'mailUsuario.email' => 'Ingrese un mail valido.',
            'mailUsuario.required' => 'El mail es obligatorio.',
            'mailUsuario.max' => 'Limite de caracteres sobrepasado.',
            'claveUsuario.min' => 'La contraseña debe contener como minimo 8 caracteres.',
            'claveUsuario.required' => 'La contraseña es obligatoria',
            'claveUsuario.confirmed' => 'Las contraseñas no coinciden.'
        ] ;
        return Validator::make($data, [
            'nombreUsuario' => ['required', 'string', 'max:255'],
            'mailUsuario' => ['required', 'string', 'email', 'max:255', 'unique:usuario'],
            'claveUsuario' => ['required', 'string', 'min:8', 'confirmed'],
        ],$mensajesErrores);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       
        
        $usuario =  User::create([
            'nombreUsuario' => $data['nombreUsuario'],
            'mailUsuario' => $data['mailUsuario'],
            'claveUsuario' => bcrypt($data['claveUsuario']),
            'auth_key' => str_random(150),
            'idRol' => 2
        ]);

        $mail = new EmailController;
        $mail->validarmail($usuario);
        return $usuario;
    
    }
}
