<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if ( Auth::check() && Auth::user()->isAdmin() )
        {
            return $next($request);
        }
        if ( Auth::check() && Auth::user()->isMaster() )
        {
            return redirect('/admin/');
        }
        if ( Auth::check() && Auth::user()->isServidor() )
        {
            return redirect('/admin/');
        }
        if ( Auth::check() && Auth::user()->isCidadao() )
        {
            return redirect('/admin/');
        }
       //
    }
}
