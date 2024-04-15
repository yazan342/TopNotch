<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $categories = [
            'tops',
            'jackets',
            'Pants',
            'shoes',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
