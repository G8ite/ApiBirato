<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCover;
use App\Models\PaperType;
use App\Models\Format;
use App\Models\IsbnCode;
use App\Models\Editor;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $authorIds = Author::pluck('id')->toArray();
        $bookCoverIds = BookCover::pluck('id')->toArray();
        $paperTypeIds = PaperType::pluck('id')->toArray();
        $formatIds = Format::pluck('id')->toArray();
        $isbnCodeIds = IsbnCode::pluck('id')->toArray();
        $editorIds = Editor::pluck('id')->toArray();

        return [
            'title' => $this->faker->sentence,
            'parution_date' => $this->faker->date,
            'validated' => $this->faker->boolean,
            'author_id' => $this->faker->randomElement($authorIds),
            'book_cover_id' => $this->faker->randomElement($bookCoverIds),
            'paper_type_id' => $this->faker->randomElement($paperTypeIds),
            'format_id' => $this->faker->randomElement($formatIds),
            'isbn_code_id' => $this->faker->randomElement($isbnCodeIds),
            'editor_id' => $this->faker->randomElement($editorIds),
        ];
    }
}
