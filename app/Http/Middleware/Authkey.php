<?php

namespace App\Http\Middleware;

use Closure;

class Authkey
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

        $token = $request->header('App_key');

        if($token!=123456)
        {
            return response()->json(['message'=>"Token invalid"],'401');
        }

        return $next($request);
    }
}
