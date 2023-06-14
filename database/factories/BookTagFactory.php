<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $bookIds = Book::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        return [
            'book_id' => $this->faker->randomElement($bookIds),
            'tag_id' => $this->faker->randomElement($tagIds),
        ];
        
    }
}