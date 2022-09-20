<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if ($re->session()->exists('usuario') && (session('rol') == 'SA' || session('rol') == 'SK' || session('rol') == 'JS')) {
            return $next($re);
        }
        return redirect('general');
    }
}
