<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Branch;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $branches = Branch::all();
        $products = Product::all();

        foreach ($branches as $branch) {
            $cashiers = User::where('branch_id', $branch->id)->where('role', 'cashier')->get();
            
            if ($cashiers->isEmpty()) continue;
            $transactionCount = rand(20, 30);
            
            for ($i = 0; $i < $transactionCount; $i++) {
                $sale = Sale::create([
                    'branch_id' => $branch->id,
                    'cashier_id' => $cashiers->random()->id,
                    'sale_date' => $faker->dateTimeBetween('-1 month', 'now'),
                    'total_price' => 0, 
                ]);
                
                $total = 0;
                $randomProducts = $products->random(rand(1, 5));
                
                foreach ($randomProducts as $product) {
                    $qty = rand(1, 3);
                    $subtotal = $qty * $product->price;
                    
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);
                    
                    $total += $subtotal;
                }
                
                $sale->update(['total_price' => $total]);
            }
        }
    }
}