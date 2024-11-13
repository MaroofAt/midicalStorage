<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scientific_name' => fake()->name(),
            'commercial_name' => fake()->name(),
            'price' => rand(10 , 10000),
            'quantity' => rand(1 , 3000),
            'info' => fake()->text(),
            'expiry_date' => fake()->date(),
            'company_id'   =>  Company::factory(),
            'category_id'   =>  Category::factory()
        ];
    }
}
