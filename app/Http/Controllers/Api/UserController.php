<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseTrait;
    public function show()
    {
        $users = User::all();
        if (! $users) {
            return $this->response(null, 404, "Not Found");
        }
        return $this->response($users, 200, "All Users Done");
    }
    public function show_one(Request $request)
    {
        $user = User::find($request->id);
        if (! $user) {
            return $this->response(null, 404, "User Not Found");
        }
        return $this->response($user, 200, "User Done");
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'min:3', 'max:20'],
            'last_name' => ['required', 'string', 'min:3', 'max:20'],
            'password' => ['required', 'password', 'min:6', 'max:20']
        ]);
        if ($validator->fails()) {
            return $this->response(null, 400, $validator->errors());
        }
        $user = User::find($request->id);
        if (! $user) {
            return $this->response(null, 404, "User Not Found");
        }
        $user->update($request->all());
    }
}
