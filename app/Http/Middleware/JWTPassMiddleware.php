<?php

namespace App\Http\Middleware;

use App\Tools\ResponseTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTPassMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            if(!isset($request['JWTPass'])) return $this->response(null , 400 , 'request does not have JWTPass variable');
            if($request['JWTPass'] != env('JWT_PASS' , '')) return $this->response(null , 400 , 'JWTPass is wrong');
            return $next($request);
        }catch(Exception $e){
            return $this->exception_response($e);
        }
    }
}
