<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Editor;
use App\Models\Author;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookWithTagsAndAuthorsResource;
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
     *             @OA\Items(ref="#/components/schemas/BookWithTagsAndAuthors")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $books = Book::with('bookTags', 'bookAuthors')->get();

        return BookWithTagsAndAuthorsResource::collection($books);
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
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(Book $book)
    {
        $book = Book::with('bookTags','bookAuthors' )->findOrFail($book->id);

        return new BookResource($book);
    }
    
    /**
     * @OA\Post(
     *     path="/api/auth/books",
     *     tags={"Book"},
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book"),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'parution_date' => 'nullable|string',
            'validated' => 'required|boolean',
            'book_cover_id' => 'nullable|integer',
            'paper_type_id' => 'nullable|integer',
            'format_id' => 'nullable|integer',
            'isbn_code_id' => 'nullable|integer',
            'editor_id' => 'nullable|integer',
            'tags' => 'nullable|array',
            'authors' => 'required|array',
        ]);

        $book = Book::create($request->all());

        if ($request->filled('tags')) {
            $tags = $request->tags; 
            $book->bookTags()->sync($tags);
        }

        if ($request->filled('authors')) {
            $author = Author::findOrFail($request->authors);
            $book->bookAuthors()->sync($author);
            $book->save();
        }

        if ($request->filled('editor_id')) {
            $editor = Editor::findOrFail($request->editor_id);
            $book->editor()->associate($editor);
            $book->save();
        }

        return new BookResource($book);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/books/{book}",
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
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'nullable|string',
            'parution_date' => 'nullable|string',
            'validated' => 'nullable|boolean',
            'book_cover_id' => 'nullable|integer',
            'paper_type_id' => 'nullable|integer',
            'format_id' => 'nullable|integer',
            'isbn_code_id' => 'nullable|integer',
            'editor_id' => 'nullable|integer',

            'tags' => 'nullable|array',
            'tags.*' => 'distinct|exists:tags,id',
            'authors' => 'nullable|array',
            'authors.*' => 'distinct|exists:authors,id',
        ]);

        $book->fill($request->only([
            'title',
            'parution_date',
            'validated',
            'book_cover_id',
            'paper_type_id',
            'format_id',
            'isbn_code_id',
            'editor_id',
        ]));

        if ($request->filled('tags')) {
            $tags = $request->tags; 
            $book->bookTags()->sync($tags);
        }

        if ($request->filled('authors')) {
            $author = Author::findOrFail($request->authors);
            $book->bookAuthors()->sync($author);
            $book->save();
        }

        $book->save();

        return new BookResource($book);
    }

    
    /**
     * @OA\Delete(
     *     path="/api/admin-only/books/{book}",
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
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
