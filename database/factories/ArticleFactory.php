<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date(),
            'name' => $this->faker->word(),
            'preview_image' => 'preview.jpg',
            'full_image' => 'full.jpg',
            'shortDesc' => $this->faker->sentence(),
            'desc' => $this->faker->text(),
        ];
    }
}
