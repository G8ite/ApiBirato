<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\BookAuthor;
use Illuminate\Http\Request;

class BookAuthorController extends Controller
{
   
    public function attach(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'author_id' => 'required|exists:authors,id',
        ]);

        $book = Book::findOrFail($request->input('book_id'));
        $author = Author::findOrFail($request->input('author_id'));

        $book->authors()->attach($author);

        return response()->json(['message' => 'Author attached to book successfully']);
    }

    
    public function detach(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'author_id' => 'required|exists:authors,id',
        ]);

        $book = Book::findOrFail($request->input('book_id'));
        $author = Author::findOrFail($request->input('author_id'));

        $book->authors()->detach($author);

        return response()->json(['message' => 'Author detached from book successfully']);
    }
}
