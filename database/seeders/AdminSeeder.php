<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(3)->create();

        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make("123456"),
            'role' => 'admin',
            "created_at" => now(),
            "updated_at" => now(),
        ]);

    }
}
