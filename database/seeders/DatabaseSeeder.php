<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::updateOrCreate(
            ['email' => 'idowu.s.adekale@gmail.com'],
            [
                'name' => 'Developer',
                'password' => Hash::make('Solomonid1@'),
                'role' => 'developer',
                'email_verified_at' => now(),
            ]
        );
    }
}
