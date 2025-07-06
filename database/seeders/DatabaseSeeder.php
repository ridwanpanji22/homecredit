<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'phone' => '0811111111',
            'no_ktp' => '1234567890123456',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Nasabah',
            'email' => 'nasabah@mail.com',
            'phone' => '0821111111',
            'no_ktp' => '2345678901234567',
            'password' => Hash::make('password'),
            'role' => 'nasabah',
        ]);

        User::create([
            'name' => 'Owner',
            'email' => 'owner@mail.com',
            'phone' => '0822222222',
            'no_ktp' => '3456789012345678',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);
    }
}
