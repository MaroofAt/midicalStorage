<?php

namespace App\Http\Middleware;

use App\Tools\ResponseTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use ResponseTrait;
    public function handle(Request $request, Closure $next): Response
    {
        // $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->response(null, 401, "Invalid Token");
            } else if ($e instanceof TokenExpiredException) {
                return $this->response(null, 401, "Expired Token");
            }
            else {
                return $this->response(null, 401, "Autheraizition Token Not Found");
            }
        } catch (Throwable $e) {
            if ($e instanceof TokenInvalidException) {
                return $this->response(null, 401, "Invalid Token");
            } else if ($e instanceof TokenExpiredException) {
                return $this->response(null, 401, "Expired Token");
            } else {
                return $this->response(null, 401, "Autheraizition Token Not Found");
            }
        }
        // if(! $user ){
        //     return $this->response(null , 401 , "Autheraizition Token Not Found");
        // }
        return $next($request);
    }
}
