<?php

namespace Database\Factories;

use App\Models\PaperType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaperTypeFactory extends Factory
{
    protected $model = PaperType::class;

    public function definition()
    {
        return [
            'paper_type_name' => $this->faker->word,
        ];
    }
}
