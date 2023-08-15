<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class ApiPermission extends Middleware
{
    protected $except = ['api/read-sensors','api/apps/connect'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
        if (!in_array( $request->route()->uri, $this->except )) {

            $header_token = $request->header( 'token' );
            if (!$header_token) {
                return response()->json( [
                    'status' => false,
                    'msg' => __( 'In valid Token' ),
                    'code' => 307,
                    'data' => false
                ], 200 );
            }
        }
        return $next( $request );
    }
}
