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
            'id_author' => $this->faker->randomElement($authorIds),
            'id_book_cover' => $this->faker->randomElement($bookCoverIds),
            'id_paper_type' => $this->faker->randomElement($paperTypeIds),
            'id_format' => $this->faker->randomElement($formatIds),
            'id_isbn_code' => $this->faker->randomElement($isbnCodeIds),
            'id_editor' => $this->faker->randomElement($editorIds),
        ];
    }
}
