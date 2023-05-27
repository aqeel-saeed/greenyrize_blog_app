<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition(): array
    {
        return [
            'encoded_image' => $this->faker->text,
            'post_id' => function () {
                return Post::factory()->create()->id;
            },
        ];
    }
}
