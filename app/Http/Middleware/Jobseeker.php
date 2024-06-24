<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use DB;

use Closure;

class Jobseeker
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
        //$ip=$request->ip();

        // if (session()->has('user')) {
            if (Auth::guard('jobseeker')->check()) {
            $usertype = Auth::guard('jobseeker')->user()->user_type;
            if ($usertype == 'Jobseeker') {
                return $next($request);
            }
        }

        return redirect()->back()->withErrors(['message' => 'Please login first by jobseeker credentials']);
    }
}
