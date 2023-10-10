<?php

namespace App\Http\Middleware;

use Closure;

class ClientAuth
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
        $user = auth()->user()->user_type;
        if (!($user == 'client')){
            return redirect(url($user)) ; 
        }
        return $next($request);
    }
}
