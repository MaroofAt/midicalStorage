<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ResponseTrait;
    // By Marouf
    // Create Read Update Delete (CRUD)
    public function show(){
        $categories = Category::all();
        return $this->response($categories , 200 , 'Success');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'title' => ['required' , 'unique:categories' , 'min:5' , 'max:255'],
            'info' => ['required' , 'min:5' , 'max:60000']
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $category = Category::create($validator->validated());
        if(!$category){
            return $this->response(null , 500 , "Can't Create Category");
        }

        return $this->response($category , 202 , "Category Created Successfully");
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'title' => ['required' , 'unique:categories' , 'min:5' , 'max:255'],
            'info' => ['required' , 'min:5' , 'max:60000']
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $category = Category::find($request->id);
        $category->update($validator->validated());
        if(!$category){
            return $this->response(null , 500 , "Can't Update Category");
        }

        return $this->response($category , 200 , "Category Updated Successfully");
    }

    public function destroy(Request $request){
        if(!isset($request->id)){
            return $this->response(null , 400 , 'Category id isn\'t exist in request');
        }

        $category = Category::find($request->id);
        if(!$category){
            return $this->response(null , 400 , 'Category id is Wrong');
        }

        Category::destroy($request->id);
        return $this->response(null , 200 , 'Category Deleted Successfully');
    }

    //// End CRUD ////

    public function get_one(Request $request){
        if(!isset($request->id)){
            return $this->response(null , 400 , 'Category id isn\'t exist in request');
        }
        $category = Category::find($request->id);
        if(!$category){
            return $this->response(null , 404 , 'Category Not Found');
        }

        return $this->response($category , 200 , 'Success');
    }
}
