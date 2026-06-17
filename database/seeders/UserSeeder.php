<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');


        User::create([
            'name' => 'Pak Jayusman',
            'email' => 'jayusman@minimarket.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'branch_id' => null,
        ]);

        $branches = Branch::all();

        foreach ($branches as $branch) {

            User::create([
                'name' => $faker->name(),
                'email' => 'manager.' . strtolower($branch->city) . '@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'branch_id' => $branch->id,
            ]);

            User::create([
                'name' => $faker->name(),
                'email' => 'supervisor.' . strtolower($branch->city) . '@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'branch_id' => $branch->id,
            ]);

            for ($i = 1; $i <= 2; $i++) {
                User::create([
                    'name' => $faker->name(),
                    'email' => 'kasir.' . strtolower($branch->city) . '.' . $i . '@minimarket.com',
                    'password' => Hash::make('password'),
                    'role' => 'cashier',
                    'branch_id' => $branch->id,
                ]);
            }

            User::create([
                'name' => $faker->name(),
                'email' => 'gudang.' . strtolower($branch->city) . '@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'warehouse',
                'branch_id' => $branch->id,
            ]);
        }
    }
}