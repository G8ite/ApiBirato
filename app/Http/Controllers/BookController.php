<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Tag;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Book")
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Book"},
     *     summary="Get all books",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $books = Book::with('tags')->get();

        return BookResource::collection($books);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{book}",
     *     tags={"Book"},
     *     summary="Get a specific book",
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function show(Book $book)
    {
        $book = Book::with('tags')->findOrFail($book->id);

        return new BookResource($book);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{book}",
     *     tags={"Book"},
     *     summary="Update a book",
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="parution_date", type="string"),
     *             
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'nullable|string',
            'parution_date' => 'nullable|string',
            'validated' => 'nullable|boolean',
            'id_author' => 'nullable|integer',
            'id_book_cover' => 'nullable|integer',
            'id_paper_type' => 'nullable|integer',
            'id_format' => 'nullable|integer',
            'id_isbn_code' => 'nullable|integer',
            'id_editor' => 'nullable|integer',

            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
        ]);

        $book->fill($request->only([
            'title',
            'parution_date',
            'validated',
            'id_author',
            'id_book_cover',
            'id_paper_type',
            'id_format',
            'id_isbn_code',
            'id_editor',
        ]));

        $book->save();

        return new BookResource($book);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Book"},
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'parution_date' => 'nullable|string',
            'validated' => 'required|boolean',
            'id_author' => 'required|integer',
            'id_book_cover' => 'nullable|integer',
            'id_paper_type' => 'nullable|integer',
            'id_format' => 'nullable|integer',
            'id_isbn_code' => 'nullable|integer',
            'id_editor' => 'nullable|integer',
            'tags' => 'nullable|array',
        ]);

        $book = Book::create($request->all());

        if ($request->filled('tags')) {
            $tags = Tag::whereIn('id', $request->tags)->pluck('id');
            $book->tags()->sync($tags);
        }

        return new BookResource($book);
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{book}",
     *     tags={"Book"},
     *     summary="Delete a book",
     *     @OA\Parameter(
     *         name="book",
     *         in="path",
     *         description="Book ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book deleted successfully"
     *     )
     * )
     */
    public function delete(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
