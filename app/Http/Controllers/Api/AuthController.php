<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ResponseTrait;
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|string|max:100|unique:users',
            'password' => 'required|password|string|min:8'
        ]);
        if ($validator->fails()) {
            return $this->response("Exception Error", 400, $validator->error());
        }
        $user = User::create($validator->validated());
        if(!$user){
            return $this->response(null, 500 , "Can't Create User");
        }
        return $this->response($user , 200 , "registered Successfully");


    }
    public function login()
    {
        // TODO.. maroof
    }
    public function logout()
    {
        // TODO.. maroof
    }
    public function me()
    {
        return $this->response(auth('api')->user());
    }
}
