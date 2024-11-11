<?php

namespace App\Http\Controllers\Api;


use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Tools\ResponseTrait;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    //
    use ResponseTrait;

    public function show()
    {
        $medicines = Medicine::with(['category', 'company'])->get();
        if (!$medicines) {
            return $this->response(null, 400, "Pad Request");
        }
        return $this->response($medicines, "200", "All Medicine Showd");
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scientific_name' => ['required', 'string', 'max:255', 'min:3'],
            'commercial_name' => ['required', 'unique:medicines', 'max:255', 'min:3'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'info' => ['required'],
            'expiry_date' => ['required', 'date'],
            'company_id' => ['required', 'exists:companies,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);
        if ($validator->fails()) {
            return $this->response($validator->errors(), 400, 'Medicine Did Not Add');
        }
        $medicine = Medicine::create($request->all());
        if ($medicine) {
            return $this->response(null, 400, 'Medicine Did Not Add');
        }
        return $this->response($validator, 200, 'Medicine Added Successfuly');
    }



    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'scientific_name' => ['required', 'string', 'max:255', 'min:3'],
            'commercial_name' => ['required', 'unique:medicines', 'max:255', 'min:3'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'info' => ['required'],
            'expiry_date' => ['required', 'date'],
            'company_id' => ['required', 'exists:companies,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);
        if ($validator->fails()) {
            return $this->response($validator->errors(), 400, 'Medicine Did Not Add');
        }

        $medicine = Medicine::find($request->id);
        if (! $medicine) {
            return $this->response(null, 404, "Medicine Did Not Found");
        }

        $medicine->update($request->all());
    }



    public function destroy(Request $request)
    {
        $medicine = Medicine::find($request->id);
        if (!$medicine) {
            return $this->response(null, 404, 'Medicine Did Not Found');
        }
        $medicine->delete($request->id);
    }


    public function show_one_medicine(Request $request)
    {
        $medicine = Medicine::find($request->id);
        if (!$medicine) {
            return $this->response(null, 404, "Medicine Did Not Found");
        }
        return $this->response($medicine, 200, "Medicine Found");
    }



    public function show_by_category(Request $request)
    {

        $medicines = Medicine::where('category_id', $request->id)->get();
        if (! Category::find($request->id)) {
            return $this->response(null, 404, "Category Not Found");
        }

        if (! $medicines) {
            return $this->response(null, 404, "Category Has No Medicine");
        }

        return $this->response($medicines, 200, "All Medicines Found");
    }


    
}
