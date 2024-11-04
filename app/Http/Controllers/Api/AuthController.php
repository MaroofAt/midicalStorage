<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register(){
        // TODO.. (Ali)
    }

    public function login(Request $request){
        // validation
        $validator = Validator::make($request->all(),[
            'email' => ['required' , 'email' , 'unique:users' , 'exists:users,email'],
            'password' => ['required' , 'min:8'],
        ]);
        if($validator->fails()){
            return $this->response($validator->errors() , 400 , 'Validation Error : Some Information is wrong');
        }

        // attempt
        $token = auth('api')->attempt($validator->validated());
        if(!$token){
            return $this->response(null , 500 , 'JWT error: can\'t generate token');
        }

        // response
        return $this->response([
            'access_token' => $token,
            'expire_date' => auth('api')->factory()->getTTl(),
        ] , 200 , 'Logined Successfully');
    }

    public function logout(){
        auth('api')->logout();
        return $this->response(null , 200 , 'Logged out Successfully');
    }

    public function me(){
        // TODO.. (Ali)
    }

    public function refresh()
    {
        return $this->response(auth()->refresh());
    }

}
