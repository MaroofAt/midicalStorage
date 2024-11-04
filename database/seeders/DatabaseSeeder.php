<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Category;
use App\Models\Medicine;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Provider\Medical;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $collection=[
            Category::factory(1)->create(),
            Company::factory(1)->create()
        ];
        Medicine::factory(100)->recycle($collection)->create();
        Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
        ]);
    }
}
