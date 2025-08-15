<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Anggota;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pinjaman>
 */
class PinjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jumlah = $this->faker->numberBetween(100000, 5000000);
        $jasa = $this->faker->numberBetween(10000, 500000);
        $total = $jumlah + $jasa;

        return [
            'id_anggota' => Anggota::factory(),
            'tgl_pinjaman' => $this->faker->date(),
            'jumlah_pinjaman' => $jumlah,
            'jasa' => $jasa,
            'total_pinjaman' => $total,
            'jaminan' => $this->faker->word(),
            'status' => $this->faker->randomElement(['pending', 'disetujui', 'ditolak']),
        ];
    }
}
