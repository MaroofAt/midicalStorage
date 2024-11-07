<?php

namespace App\Http\Controllers\Api;


use App\Models\Company;
use App\Tools\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class CompanyController extends Controller
{
    use ResponseTrait;
    // By Marouf
    // Create Read Update Delete (CRUD)
    public function show(){
        $companies = Company::all();
        return $this->response($companies , 200 , 'Success');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'title' => ['required' , 'unique:categories' , 'min:5' , 'max:255']
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $company= Company::create($validator->validated());
        if(!$company){
            return $this->response(null , 500 , "Can't Create new Company Title");
        }

        return $this->response($company , 202 , "Company Title Created Successfully");
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'title' => ['required' , 'unique:categories' , 'min:5' , 'max:255'],
        ]);
        if($validator->fails()){
            return $this->response("Validation Error" , 400 , $validator->errors());
        }

        $company = Company::find($request->id);
        $company->update($validator->validated());
        if(!$company){
            return $this->response(null , 500 , "Can't Update Company Title");
        }

        return $this->response($company , 200 , "Company Title Updated Successfully");
    }

    public function destroy(Request $request){
        if(!isset($request->id)){
            return $this->response(null , 400 , 'Company id isn\'t exist in request');
        }

        $company = Company::find($request->id);
        if(!$company){
            return $this->response(null , 400 , 'Company id is Wrong');
        }

        Company::destroy($request->id);
        return $this->response(null , 200 , 'Company Deleted Successfully');
    }

    //// End CRUD ////

    public function get_one(Request $request){
        if(!isset($request->id)){
            return $this->response(null , 400 , 'Company id isn\'t exist in request');
        }
        $company = Company::find($request->id);
        if(!$company){
            return $this->response(null , 404 , 'Company Not Found');
        }

        return $this->response($company , 200 , 'Success');
    }
}
