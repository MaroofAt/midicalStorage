<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Company;
use App\Models\Medicine;
use App\Models\Order;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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

        //Order::factory(40)->recycle([User::factory(25)->create()])->create();
        $collection = [
            Category::factory()->count(10)->create(),
            Company::factory()->count(14)->create()
        ];
        $medicines = Medicine::factory()->count(50)->recycle($collection)->create();
        Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
        ]);

        Order::factory()
            ->count(40)
            ->recycle([User::factory(25)->create()])
            ->create()
            ->each(function ($order) use ($medicines) {
                $medicinesToAttach = $medicines->random(rand(2, 5))->pluck('id')->toArray();

                foreach ($medicinesToAttach as $medicineId) {
                    $order->medicines()->attach($medicineId, ['quantity' => rand(1, 10)]);
                }
            });
    }
}
