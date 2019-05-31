<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class Ativo
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
        if($request->user()->ativo == 0 || $request->user()->trashed()){
            Auth::logout();
            return redirect()->route('login')->withErrors(["errors" => "Utilizador não está ativo"]);
        }
        if(Auth::user()->password_inicial){
            return redirect()->route('home');
        }
        return $next($request);
    }
}
