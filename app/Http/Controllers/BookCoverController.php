<?php

namespace App\Http\Controllers;

use App\Models\BookCover;
use Illuminate\Http\Request;

class BookCoverController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/book_covers",
     *     tags={"Book Covers"},
     *     summary="Get all book covers",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/BookCover")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $bookCovers = BookCover::all();

        return response()->json(['book_covers' => $bookCovers]);
    }

    
    /**
     * @OA\Get(
     *     path="/api/book_covers/{book_cover}",
     *     tags={"Book Covers"},
     *     summary="Get a specific book cover",
     *     @OA\Parameter(
     *         name="book_cover",
     *         in="path",
     *         description="ID of the book cover",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BookCover")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(BookCover $book_cover)
    {
        return response()->json(['book_cover' => $book_cover]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/book_covers",
     *     tags={"Book Covers"},
     *     summary="Create a new book cover",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookCover")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BookCover")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_cover_name' => 'required|string',
        ]);

        $bookCover = BookCover::create($request->all());

        return response()->json(['book_cover' => $bookCover], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/book_covers/{book_cover}",
     *     tags={"Book Covers"},
     *     summary="Update a book cover",
     *     @OA\Parameter(
     *         name="book_cover",
     *         in="path",
     *         description="ID of the book cover",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BookCover")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/BookCover")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, BookCover $book_cover)
    {
        $request->validate([
            'book_cover_name' => 'required|string',
        ]);

        $book_cover->update($request->all());

        return response()->json(['book_cover' => $book_cover]);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/book_covers/{book_cover}",
     *     tags={"Book Covers"},
     *     summary="Delete a book cover",
     *     @OA\Parameter(
     *         name="book_cover",
     *         in="path",
     *         description="ID of the book cover",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Book cover deleted successfully")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(BookCover $book_cover)
    {
        $book_cover->delete();

        return response()->json(['message' => 'Book cover deleted successfully']);
    }
}
