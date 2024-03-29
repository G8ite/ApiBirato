<?php

namespace Database\Factories;

use App\Models\Editor;
use Illuminate\Database\Eloquent\Factories\Factory;

class EditorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Editor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'editor_name' => $this->faker->name(),
        ];
    }
}
