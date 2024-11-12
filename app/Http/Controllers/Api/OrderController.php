<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Order;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ResponseTrait;
    // By Marouf
    // Create Read Update Delete

    public function show(){
        $orders = Order::all();
        return $this->response($orders , 200 , 'Success');
    }

    public function store_one(Request $request){
        $validator = Validator::make($request->all() , [
            'status' => ['in:preparing,sent,arrived'],
            'paid' => ['boolean'],
            'quantity' => ['required' , 'numeric'],
            'user_id' => ['required' , 'exists:users,id'],
            'medicine_id' => ['required' , 'exists:medicines,id'],
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $medicine = Medicine::find($request->medicine_id);
        if(!$medicine){
            return $this->response(null , 404 , "didn't find Medicine with that medicine_id");
        }

        $order = Order::create($validator->validated());
        if(!$order){
            return $this->response(null , 500 , "Can't Create Order");
        }

        $order->medicines()->attach($medicine , ['quantity' => $request->quantity]);

        return $this->response($order , 202 , "Order Created Successfully");
    }

    public function store_full_order(Request $request){

    }

    public function update_status_paid(Request $request){
        $validator = Validator::make($request->all(), [
            'status' => ['required' , 'in:preparing,sent,arrived'],
            'paid' => ['required' ,'boolean'],
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $order = Order::find($request->id);
        $order->update($validator->validated());
        if(!$order){
            return $this->response(null , 500 , "Can't Update Order");
        }

        return $this->response($order , 200 , "Order Updated Successfully");
    }

    public function destroy(Request $request){
        if(!isset($request->id)){
            return $this->response(null , 400 , 'Order id isn\'t exist in request');
        }

        $order = Order::find($request->id);
        if(!$order){
            return $this->response(null , 400 , 'Order id is Wrong');
        }

        Order::destroy($request->id);
        return $this->response(null , 200 , 'Order Deleted Successfully');
    }

    //// End CRUD ////
}
