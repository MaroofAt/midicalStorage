<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    /** @use HasFactory<\Database\Factories\MedicineFactory> */
    use HasFactory;

    protected $fillable = [
        'scientific_name',
        'commercial_name',
        'price',
        'quantity',
        'info',
        'company_id',
        'category_id',
        'expiry_date'
    ];

    public function company(){
        return $this->belongsTo(Company::class , 'company_id' , 'id');
    }
    public function category(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }
    public function orders(){
        return $this->belongsToMany(Order::class);
    }
}
