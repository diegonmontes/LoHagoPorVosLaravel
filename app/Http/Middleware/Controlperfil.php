<?php

namespace App\Http\Middleware;

use Closure;
use App\Persona;
use Auth;

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
            $idUsuario = Auth::user()->idUsuario;
            if(count(Persona::where('idUsuario','=',$idUsuario)->get())<1){
                return redirect('usuario/perfil');
            }
        }else{
            return redirect('login');
        }
        return $next($request);
    }
}
