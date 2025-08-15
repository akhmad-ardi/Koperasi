<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sekolah;
use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\Penarikan;
use App\Models\Simpanan;
use App\Models\Pinjaman;
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
        User::factory(3)->create();

        User::factory()->create([
            'username' => 'admin',
            'password' => Hash::make("123456"),
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        Sekolah::factory(3)
            ->has(
                Anggota::factory(3)
                    ->has(Simpanan::factory(3))
                    ->has(Pinjaman::factory(3)->has(Angsuran::factory(3)))
                    ->has(Penarikan::factory(3))
            )->create();
    }
}
