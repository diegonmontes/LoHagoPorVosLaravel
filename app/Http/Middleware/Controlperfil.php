<?php

namespace App\Http\Middleware;

use Closure;
use App\Persona;
use App\Http\Controllers\PersonaController;
use Auth;
use Illuminate\Http\Request;


class Controlperfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $controlPersona = new PersonaController;
            $idUsuario = Auth::user()->idUsuario;
            $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
            $param = new Request($param);
            $persona = $controlPersona->buscar($param);
            $persona = json_decode($persona);

            if(count($persona)<1){
                return redirect('usuario/perfil');
            }
        }else{
            return redirect('login');
        }
        return $next($request);
    }
}
