<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['name' => 'Indomie Goreng', 'price' => 3500],
            ['name' => 'Aqua 600ml', 'price' => 4000],
            ['name' => 'Teh Pucuk Harum', 'price' => 5000],
            ['name' => 'Chitato Sapi Panggang', 'price' => 12000],
            ['name' => 'Ultra Milk Coklat', 'price' => 7000],
        ]);
    }
}