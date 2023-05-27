<?php

namespace Database\Factories;

use App\Models\NewsLetterEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NewsLetterEmailFactory extends Factory
{
    protected $model = NewsLetterEmail::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
        ];
    }
}
