<?php

namespace Database\Factories;

use App\Models\Anggota;
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
            'id_anggota' => Anggota::factory(),
            'tgl_angsuran' => $this->faker->date(),
            'jumlah_angsuran' => $this->faker->numberBetween(500000, 2000000),
            'jasa' => $this->faker->numberBetween(50000, 200000),
            'total_angsuran' => $this->faker->numberBetween(550000, 2200000),
        ];
    }
}
