<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Wisnu',
            'email' => 'wisnu@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('pass123'),
            'remember_token' => Str::random(10),
        ]);

        // Call ProductsSeeder
        $this->call(ProductsSeeder::class);
    }
}