<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Tag::factory(10)->create();
        \App\Models\Format::factory(10)->create();
        \App\Models\BookCover::factory(10)->create();
        \App\Models\PaperType::factory(10)->create();
        \App\Models\Author::factory(10)->create();
        \App\Models\Editor::factory(10)->create();
        \App\Models\Status::factory(10)->create();
        \App\Models\ConservationState::factory(10)->create();
        \App\Models\IsbnCode::factory(10)->create();
        \App\Models\Book::factory(10)->create();
        \App\Models\BookTag::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\UserBook::factory(10)->create();
        
        $booksIDs = \App\Models\Book::pluck('id')->toArray();
        $authorsIDs = \App\Models\Author::pluck('id')->toArray();
        foreach ($booksIDs as $bookID) {
            \App\Models\BookAuthor::factory()->create([
                'book_id' => $bookID,
                'author_id' => $authorsIDs[array_rand($authorsIDs)],
            ]);
        }

    }
}
