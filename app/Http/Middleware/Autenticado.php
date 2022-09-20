<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Autenticado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $re, Closure $next)
    {
        if ($re->session()->exists('usuario') && $re->session()->exists('ruc')) {
            return $next($re);
        }
        return redirect('/');
    }
}
