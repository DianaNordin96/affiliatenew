<?php

namespace App\Http\Middleware;

use Closure;

class DamyuMiddleware
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
        if ($request->user() && $request->user()->role != 'damio')
        {
        return redirect('/unauthorized');
        }
        return $next($request);
    }
}
