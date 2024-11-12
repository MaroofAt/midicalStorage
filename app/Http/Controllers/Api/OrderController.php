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


        if(!$this->insureMedicineQuantity($request->quantity , $request->medicine_id)){
            return $this->response(null , 400 , 'Order Can\'t be created, There is\'t enough medicines');
        }

        if(!$order = $this->createOrder($request->medicine_id , $validator->validated())){
            return $this->response(null , 500 , 'Order Can\'t be created');
        }

        return $this->response($order , 201 , "Order Created Successfully");
    }

    public function store_full_order(Request $request){
        $validator = Validator::make($request->user_id , [
            'user_id' => ['required' , 'exists:users,id'],
            'medicines.*.id' => ['required' , 'exists:medicines,id'],
            'medicines.*.quantity' => ['required' , 'numeric'],
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        foreach($request->medicines as $one){
            if(!$this->insureMedicineQuantity($one->quantity , $one->id)){
                return $this->response(null , 400 , $one->commercial_name . ": medicine quantity is less than required quantity");
            }
        }
        foreach($request->medicines as $one){
            $this->createOrder($one->id , [
                "status" => "preparing",
                "paid" => "false",
                'quantity' => $one->quantity,
                'user_id' => $request->user_id,
                'medicine_id' => $one->id,
            ]);
        }

        return $this->response(null , 201 , "Full Order Created Successfully");
    }
    private function insureMedicineQuantity($request_quantity , $medicine_id): bool {
        $medicine = Medicine::find($medicine_id);
        if($request_quantity > $medicine->quantity){
            return false;
        }
        return true;
    }
    private function createOrder(int $medicine_id , $validated_data){

        $medicine = Medicine::find($medicine_id);
        if(!$medicine){
            return $this->response(null , 404 , "didn't find Medicine with that medicine_id");
        }


        $order = Order::create($validated_data);
        if(!$order){
            return $this->response(null , 500 , "Can't Create Order");
        }

        $order->medicines()->attach($medicine , ['quantity' => $validated_data->quantity]);
        return $order;
    }



    public function update_status_paid(Request $request){ // Have To be Tested (Not Tested Yet)
        $validator = Validator::make($request->all(), [
            'id' =>['required'],
            'status' => ['required' , 'in:inCart,preparing,sent,arrived'],
            'paid' => ['required' ,'boolean'],
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $order = Order::find($request->id);
        if(!$order){
            return $this->response(null , 404 , "Order Not Found");
        }

        if($request->status === 'sent'){
            // Here is the Conclusion that have to be tested
            $medicine = Medicine::find($order->medicine_id)->with('orders');
            $medicine->update(['quantity' => ($medicine->quantity - $medicine->pivot->quantity)]);
        }

        $order->update($validator->validated());

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


    public function get_by_date_and_user(Request $request){
        $validator = Validator::make($request->all() , [
            'date' => ['required' , 'date'],
            'user_id' => ['required' , 'exists:users,id'],
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $orders = Order::where('user_id' , $request->user_id)->where('created_at' , $request->date)->get();
        if(!$orders){
            return $this->response(null , 404 , 'There aren\'t orders in that date for this user');
        }

        return $this->response($orders , 200 , 'Success');
    }



}
