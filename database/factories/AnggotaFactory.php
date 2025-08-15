<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sekolah;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_sekolah' => Sekolah::factory(),
            'no_anggota' => $this->faker->unique()->numerify('AGT####'),
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['laki-laki', 'perempuan']),
            'tempat_lahir' => $this->faker->city(),
            'tgl_lahir' => $this->faker->date(),
            'pekerjaan' => $this->faker->jobTitle(),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->faker->numerify('08###########'),
            'nik' => $this->faker->numerify('################'),
            'nip' => $this->faker->numerify('##################'),
            'foto_diri' => 'default.jpg',
            'status' => $this->faker->randomElement(['aktif', 'nonaktif']),
            'tgl_gabung' => $this->faker->date(),
        ];
    }
}
