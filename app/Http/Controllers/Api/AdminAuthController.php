<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    use ResponseTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'between:3,30'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        if ($validator->fails()) {
            return $this->response("Validation Error", 400, $validator->errors());
        }

        $admin = Admin::create($validator->validated());
        if (!$admin) {
            return $this->response(null, 500, "Can't Create Admin");
        }

        return $this->response($admin, 202, "registered Successfully");
    }

    public function login(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:admins,email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return $this->response($validator->errors(), 400, 'Validation Error : Some Information is wrong');
        }

        // attempt
        $token = auth('api_admin')->attempt($validator->validated());
        if (!$token) {
            return $this->response(null, 500, 'JWT error: can\'t generate token');
        }

        // response
        return $this->response([
            'access_token' => $token,
            'expire_date' => JWTAuth::factory()->getTTl(),
        ], 200, 'Logined Successfully');
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        auth('api_admin')->logout();
        return $this->response(null, 200, 'Logged out Successfully');
    }

    public function me()
    {
        return $this->response(auth('api_admin')->user());
    }
    public function refresh()
    {
        return $this->response(JWTAuth::refresh());
    }
}
