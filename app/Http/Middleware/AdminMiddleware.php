<?php

namespace App\Http\Middleware;
use \Illuminate\Http\Response;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::user()->role != 'admin')
        {
            return redirect('/login');
        }
        return $next($request);
    }
}
