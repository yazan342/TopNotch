<?php

namespace Database\Factories;

use App\Models\GenderCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenderCategoryFactory extends Factory
{
    protected $model = GenderCategory::class;

    public function definition()
    {
        $categories = [
            'Male',
            'Female',

        ];

        return [
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
