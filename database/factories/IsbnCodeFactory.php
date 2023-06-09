<?php

namespace Database\Factories;

use App\Models\IsbnCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class IsbnCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IsbnCode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->numerify('##########'),
            'validated' => $this->faker->boolean(),
        ];
    }
}
