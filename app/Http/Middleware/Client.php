<?php

namespace App\Http\Middleware;

use Request;
use Closure;
use Auth;

class Client{

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
        	if (Auth::user()->user_type != 0) { // Not admin
            	return $next($request);
            }
        }
        return redirect('?redirect&uri='.Request::url());
    }

}