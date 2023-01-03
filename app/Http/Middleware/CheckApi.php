<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class NoCache
 * @package App\Http\Middleware
 */
class CheckApi
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
        $header = $request->header('key');

        if ($header && $header == 'HiJhvL$T27@1u^%u86g') {
            // return new User();
            return $next($request);   
        }

        if(empty($header)){
            return response()->json(['error' => 'API key is missing.'], 403);
        }


        return response()->json(['error' => 'Invalid API key.'], 401);
    }
}