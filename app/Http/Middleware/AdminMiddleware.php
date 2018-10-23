<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use App\Models\Admin;

class AdminMiddleware{

    public function handle($request, Closure $next){
        if(!Admin::check()){
            return redirect('admin?authenticate=invalid&uri='.Request::url());
        }
        return $next($request);
    }
    
}