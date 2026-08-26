<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCMSAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $arr_can_access_backend = [1, 4, 6, 7];
        if (!in_array(Auth::user()->user_group, $arr_can_access_backend)) {
            return redirect()->route('home');
        }
        
        return $next($request);
    }
}
