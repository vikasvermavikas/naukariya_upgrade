<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Http\Request;
use Session;
use DB;

use Closure;

class Subuser
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('subuser')->check()) {

            return $next($request);
        }
        return redirect('/');
    }
}
