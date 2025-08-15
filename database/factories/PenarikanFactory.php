<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Anggota;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penarikan>
 */
class PenarikanFactory extends Factory
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
            'tgl_penarikan' => $this->faker->date(),
            'jenis_simpanan' => $this->faker->randomElement(['pokok', 'wajib', 'sukarela']),
            'jumlah_penarikan' => $this->faker->numberBetween(10000, 500000),
            'keterangan' => $this->faker->sentence(5),
        ];
    }
}
