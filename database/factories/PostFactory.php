<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title_en' => $this->faker->sentence,
            'title_ar' => $this->faker->sentence,
            'content_en' => $this->faker->paragraph,
            'content_ar' => $this->faker->paragraph,
            'views' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['published', 'draft', 'deleted']),
            'slug' => $this->faker->slug,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
