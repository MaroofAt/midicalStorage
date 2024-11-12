<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ResponseTrait;
    public function show()
    {
        $admin = Admin::all();
        if (! $admin) {
            return $this->response(null, 404, "Not Found");
        }
        return $this->response($admin, 200, "All Admins Done");
    }
    public function show_one(Request $request)
    {
        $admin = Admin::find($request->id);
        if (! $admin) {
            return $this->response(null, 404, "User Not Found");
        }
        return $this->response($admin, 200, "User Done");
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'password' => ['required', 'password', 'min:6', 'max:20']
        ]);
        if ($validator->fails()) {
            return $this->response(null, 400, $validator->errors());
        }
        $admin = Admin::find($request->id);
        if (! $admin) {
            return $this->response(null, 404, "Admin Not Found");
        }
        $admin->update($request->all());
    }
}
