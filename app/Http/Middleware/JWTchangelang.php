<?php

namespace App\Http\Middleware;

use App\tools\Responsetrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTchangelang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use Responsetrait;
    public function handle(Request $request, Closure $next): Response
    {
        try{
            if(!isset($request->lang)) $this->response($request , 404 , "NOT FOUND");
            if($request->lang == 'english'){
                app()->setlocale('english');
            }else{
                app()->setlocale('arabic');
            }
            return $next($request);
        }catch(Exception $ex){
            return $this -> exception_response($ex);
        }

    }
}
