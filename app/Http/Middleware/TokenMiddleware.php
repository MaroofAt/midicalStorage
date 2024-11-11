<?php

namespace App\Http\Middleware;

use \Tymon\JWTAuth\Exceptions\TokenExpiredException;
use \Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Tools\ResponseTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }catch(Exception $e) {
            if ($e instanceof TokenInvalidException){
                return $this->response(null , 401 , 'Token is Invalid');
            }else if ($e instanceof TokenExpiredException){
                return $this->response(null , 401 , 'Token is Expired');
            }else{
                return $this->response(null , 401 , 'Authorization Token not found');
            }
        }
        return $next($request);
    }
}
