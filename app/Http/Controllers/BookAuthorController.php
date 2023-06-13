<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\BookAuthor;
use Illuminate\Http\Request;

class BookAuthorController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/book-authors/attach",
     *     tags={"BookAuthor"},
     *     summary="Attach an author to a book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"book_id", "author_id"},
     *                 @OA\Property(property="book_id", type="integer", example=1),
     *                 @OA\Property(property="author_id", type="integer", example=1),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author attached to book successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Author attached to book successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book or author not found"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/book-authors/detach",
     *     tags={"BookAuthor"},
     *     summary="Detach an author from a book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"book_id", "author_id"},
     *                 @OA\Property(property="book_id", type="integer", example=1),
     *                 @OA\Property(property="author_id", type="integer", example=1),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author detached from book successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Author detached from book successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book or author not found"
     *     )
     * )
     */
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
