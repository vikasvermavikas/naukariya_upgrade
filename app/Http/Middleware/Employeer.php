<?php

namespace App\Http\Middleware;

use Auth;
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
        $usertype = Session::get('user')['user_type'];
        if ($usertype == 'Employer') {
            return $next($request);
        }
        return redirect('/');
    }
}
