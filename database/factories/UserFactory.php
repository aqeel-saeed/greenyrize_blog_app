<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name_en' => $this->faker->firstName,
            'last_name_en' => $this->faker->lastName,
            'first_name_ar' => $this->faker->firstName,
            'last_name_ar' => $this->faker->lastName,
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'), // default password is "password"
            'encoded_image' => null,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'role' => 'user',
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
