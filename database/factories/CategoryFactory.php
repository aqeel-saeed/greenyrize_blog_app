<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name_en' => $this->faker->name,
            'name_ar' => $this->faker->name,
            'description_en' => $this->faker->text,
            'description_ar' => $this->faker->text,
            'encoded_image' => $this->faker->text,
        ];
    }
}
