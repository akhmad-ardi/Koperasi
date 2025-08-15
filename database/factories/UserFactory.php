<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['ketua', 'admin'];

        return [
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('123456'),
            'peran' => $roles[rand(0, 1)],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
