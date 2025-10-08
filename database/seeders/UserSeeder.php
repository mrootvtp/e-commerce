<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name' => 'Admin User',
            'email' => 'mohammed@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => \Illuminate\Support\Str::random(10),
            
        ]);

        user::factory()->count(10)->create();

    }
}
