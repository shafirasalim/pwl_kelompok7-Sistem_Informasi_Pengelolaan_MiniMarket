<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'Indomie Goreng', 'Indomie Kuah Soto', 'Sedaap Goreng', 
            'Aqua 600ml', 'Aqua 1500ml', 'Le Minerale 600ml', 
            'Teh Pucuk Harum', 'Teh Botol Sosro', 'Nu Green Tea',
            'Chitato Sapi Panggang', 'Chitato Ayam Bawang', 'Qtela Singkong Balado',
            'Ultra Milk Coklat', 'Ultra Milk Strawberry', 'Bear Brand',
            'Kopiko Brown Coffee', 'Taro Net Seaweed', 'Oreo Original',
            'Tolak Angin', 'Antangin JRG', 'Panadol Biru', 'Paramex',
            'Sabun Lifebuoy', 'Shampoo Clear', 'Pasta Gigi Pepsodent'
        ];

        $faker = \Faker\Factory::create('id_ID');

        foreach ($products as $product) {
            Product::create([
                'name' => $product,
                'price' => $faker->numberBetween(4, 100) * 500, 
            ]);
        }
    }
}