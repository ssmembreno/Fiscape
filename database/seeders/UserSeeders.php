<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;            
use Illuminate\Support\Facades\Hash; 

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'samuel.mem123@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
