<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'branch_id' => 1,
                'name' => 'Manager Sukabumi',
                'email' => 'manager1@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'branch_id' => 1,
                'name' => 'Supervisor Sukabumi',
                'email' => 'supervisor1@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
            ],
            [
                'branch_id' => 1,
                'name' => 'Kasir Sukabumi',
                'email' => 'kasir1@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ],
            [
                'branch_id' => 1,
                'name' => 'Gudang Sukabumi',
                'email' => 'gudang1@minimarket.com',
                'password' => Hash::make('password'),
                'role' => 'gudang',
            ],
        ]);
    }
}