<?php

namespace Database\Factories;

use App\Models\Format;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormatFactory extends Factory
{
    protected $model = Format::class;

    public function definition()
    {
        return [
            'format_name' => $this->faker->word,
        ];
    }
}
