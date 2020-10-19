<?php

namespace App\Http\Middleware;
use \Illuminate\Http\Response;
use Closure;
use Illuminate\Support\Facades\Auth;

class DropshipMiddleware
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
        if (Auth::user()->role != 'dropship')
        {
            return redirect('/login');
        }
        return $next($request);
    }
}
