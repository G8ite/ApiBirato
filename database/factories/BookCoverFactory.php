<?php

namespace Database\Factories;

use App\Models\BookCover;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookCoverFactory extends Factory
{
    protected $model = BookCover::class;

    public function definition()
    {
        return [
            'book_cover_name' => $this->faker->word,
        ];
    }
}
