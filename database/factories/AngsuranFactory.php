<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pinjaman;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Angsuran>
 */
class AngsuranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pinjaman' => Pinjaman::factory(), // atau isi manual id anggota
            'angsuran_ke' => $this->faker->numberBetween(1, 36),
            'tgl_angsuran' => $this->faker->date(),
            'jumlah_angsuran' => $this->faker->numberBetween(500000, 2000000),
            'jasa' => $this->faker->numberBetween(50000, 200000),
            'tunggakan_jasa' => $this->faker->numberBetween(0, 50000),
            'total_angsuran' => $this->faker->numberBetween(550000, 2200000),
            'sisa_pinjaman' => $this->faker->numberBetween(0, 5000000),
            'status' => $this->faker->randomElement(['lunas', 'belum lunas']),
        ];
    }
}
