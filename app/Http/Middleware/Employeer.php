<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use DB;

use Closure;

class Employeer
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('employer')->check()) {
            $usertype = Auth::guard('employer')->user()->user_type;
            if ($usertype == 'Employer') {
                return $next($request);
            }
        }
        return redirect()->route('loadLoginPage');
    }
}
