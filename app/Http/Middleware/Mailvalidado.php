<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Mailvalidado
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
            $mailValidado = Auth::user()->email_verified_at;
            if($mailValidado == null){
                Auth::logout();
                return redirect('login')->with('success','Revise su correo para validar su mail.');
            }
        }
        return $next($request);
    }
}
