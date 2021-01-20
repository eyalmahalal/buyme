<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'     => 'Content-Type, Accept, Authorization, X-Requested-With, Origin'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('ok', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;

        // return $next($request)
            // ->header('Access-Control-Allow-Origin', '*')
            // ->header('Access-Control-Allow-Headers', 'Authorization, X-Auth-Token, Origin, Content-Type')
            // ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
    }
}
