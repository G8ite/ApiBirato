<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Get all authors",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="authors", type="array", @OA\Items(ref="#/components/schemas/Author"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $authors = Author::all();

        return AuthorResource::collection($authors);
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Create a new author",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
        ]);

        $author = Author::create($request->all());

        return new AuthorResource($author);
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{author}",
     *     tags={"Authors"},
     *     summary="Get a specific author",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Author ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{author}",
     *     tags={"Authors"},
     *     summary="Update an existing author",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Author ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
        ]);

        $author->fill($request->only([
            'name',
            'surname',
        ]));

        $author->save();

        return new AuthorResource($author);
    }

    /**
     * @OA\Delete(
     *     path="/api/authors/{author}",
     *     tags={"Authors"},
     *     summary="Delete an author",
     *     @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="Author ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Author deleted successfully")
     *         )
     *     )
     * )
     */
    public function delete(Author $author)
    {
        $author->delete();

        return response()->json(['message' => 'Author deleted successfully']);
    }
}
