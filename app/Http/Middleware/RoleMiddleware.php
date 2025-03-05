<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
        public function handle(Request $request, Closure $next, ...$roles)
    {
        
        if (in_array('all', $roles)) {
            return $next($request); 
        }

        if (!in_array($request->user()->usertype, $roles)) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }
        
        return $next($request);
    }
}
