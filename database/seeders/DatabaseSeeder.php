<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\Penarikan;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class
        ]);

        Sekolah::factory(3)
            ->has(
                Anggota::factory(3)
                    ->has(Simpanan::factory(3))
                    ->has(Pinjaman::factory(3)
                        ->has(Angsuran::factory(1)))
                    ->has(Penarikan::factory(3))
            )->create();
    }
}
