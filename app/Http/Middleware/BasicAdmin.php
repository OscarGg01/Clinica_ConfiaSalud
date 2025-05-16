<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->getUser();
        $pass = $request->getPassword();

        if ($user !== 'AdminConfiaSalud' || $pass !== '12345678') {
            return response('Unauthorized', 401)
                   ->header('WWW-Authenticate', 'Basic realm="Admin Area"');
        }

        return $next($request);
    }
}
