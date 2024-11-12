<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\User;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register(Request $request)
    {
        //return $this->response($request->get('phone_number') , 400 , strlen($request->get('phone_number')));
        $validator = Validator::make($request->all(), [
            'first_name' => ['required','between:3,30'],
            'last_name' => ['required','between:3,30'],
            'phone_number' => ['required', 'digits:10' , 'numeric', 'unique:users'],
            'password' => ['required','min:8' , 'confirmed']
        ]);
        if ($validator->fails()) {
            return $this->response("Validation Error", 400, $validator->errors());
        }

        $user = User::create($validator->validated());
        if(!$user){
            return $this->response(null, 500 , "Can't Create User");
        }

        return $this->response($user , 202 , "registered Successfully");
    }

    public function login(Request $request){
        // validation
        $validator = Validator::make($request->all(),[
            'phone_number' => ['required' , 'exists:users,phone_number'],
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
            'expire_date' => JWTAuth::factory()->getTTl(),
        ] , 200 , 'Logined Successfully');
    }

    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        auth('api')->logout();
        return $this->response(null , 200 , 'Logged out Successfully');
    }

    public function me(){
        return $this->response(auth('api')->user());
    }
    public function refresh(){
        return $this->response(JWTAuth::refresh());
    }

    

}
