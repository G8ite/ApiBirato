<?php

namespace Database\Factories;

use App\Models\ConservationState;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConservationStateFactory extends Factory
{

    protected $model = ConservationState::class;

    public function definition()
    {
        return [
            'state_name' => $this->faker->word,
        ];
    }
}
