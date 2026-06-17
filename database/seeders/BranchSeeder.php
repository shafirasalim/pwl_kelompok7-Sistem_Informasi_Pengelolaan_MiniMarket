<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $cities = ['Sukabumi', 'Bandung', 'Bogor', 'Jakarta', 'Cianjur'];

        foreach ($cities as $city) {
            Branch::create([
                'name' => 'Mini Market Jayusman ' . $city,
                'city' => $city,
                'address' => $faker->address(), 
            ]);
        }
    }
}