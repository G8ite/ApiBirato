<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Editor;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        
        Book::factory(10)->create();

        $response = $this->get('/api/books');

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');
    }

    public function testShow()
    {
        $book = Book::factory()->create();

        $response = $this->get('/api/books/' . $book->id);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'title' => $book->title,
                'parution_date' => $book->parution_date,
                'validated' => $book->validated,
                'book_cover_id' => $book->book_cover_id,
                'paper_type_id' => $book->paper_type_id,
                'format_id' => $book->format_id,
                'isbn_code_id' => $book->isbn_code_id,
                'editor_id' => $book->editor_id,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ]
        ]);
    }
}
