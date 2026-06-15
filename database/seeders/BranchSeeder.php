<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::insert([
            ['name' => 'Mini Market Jayusman Sukabumi', 'city' => 'Sukabumi', 'address' => 'Jl. Raya Sukabumi No. 1'],
            ['name' => 'Mini Market Jayusman Bandung', 'city' => 'Bandung', 'address' => 'Jl. Asia Afrika No. 10'],
            ['name' => 'Mini Market Jayusman Bogor', 'city' => 'Bogor', 'address' => 'Jl. Pajajaran No. 25'],
            ['name' => 'Mini Market Jayusman Jakarta', 'city' => 'Jakarta', 'address' => 'Jl. Sudirman No. 88'],
            ['name' => 'Mini Market Jayusman Cianjur', 'city' => 'Cianjur', 'address' => 'Jl. Siliwangi No. 15'],
        ]);
    }
}