<?php

namespace App\Http\Middleware;

use Closure;

class DelegateAuth
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
        if (!($user == 'delegate')){
            return redirect(url($user)) ; 
        }
        return $next($request);
    }
}
