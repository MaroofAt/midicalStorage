<?php

namespace App\Http\Middleware;

use App\Tools\ResponseTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
        try{
            $user = auth('api')->user();
            if(!$user) return $this->response(null , 400 , 'Token is Wrong or Not Exist');
            return $next($request);
        }catch(Exception $e){
            return $this->exception_response($e);
        }
    }
}
