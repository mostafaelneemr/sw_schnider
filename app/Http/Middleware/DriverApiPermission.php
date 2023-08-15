<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
class DriverApiPermission extends Middleware
{
    protected $except = [ ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::guard('driver_api')->check()) {

            //user not verified
            if ((Auth::guard('driver_api')->user()->verified_at == null)){
                return response()->json([
                    'status' => false,
                    'msg' => __('Account not verified yet'),
                    'code' => 308,
                    'data'=>false
                ],200);
            }
            if ((Auth::guard('driver_api')->user()->status == 'inactive')){
                return response()->json([
                    'status' => false,
                    'msg' => __('Your Account is In Active Please Call The Support'),
                    'code' => 309,
                    'data'=>false
                ],200);
            }
        }else{

                $token = 'cc1a39ecdca4bcfcad8336eb5484e134'; // md5(date('Y-m').'_Osouly');
            $header_token = $request->header('token');
            if($token != $header_token ){
                  return response()->json([
                    'status' => false,
                    'msg' => __('In valid Token'),
                    'code' => 307,
                    'data'=>false
                ],200);
            }


        }
         return $next($request);
    }
}
