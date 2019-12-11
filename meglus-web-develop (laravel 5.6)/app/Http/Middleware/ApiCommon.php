<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Exception\UnknownVersionException;

class ApiCommon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $header = getallheaders();
        if (!isset($header['api_key']) || $header['api_key'] !=  env('API_KEY', 'G87DF8G7DF9DASD0933HJK09HJ')) {
            //throw new UnknownVersionException('key is invalid!');
            return response()->json(['status_code' => 400, 'errors' => ['invalid_api_key']]);
        }

        return $next($request);
    }
}
