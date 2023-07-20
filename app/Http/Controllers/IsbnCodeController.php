<?php

namespace App\Http\Controllers;

use App\Models\IsbnCode;
use App\Http\Resources\IsbnCodeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookWithTagsAndAuthorsResource;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\Editor;

/**
 * @OA\Tag(name="Isbn Code")
 */
class IsbnCodeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/isbn_codes",
     *     tags={"Isbn Code"},
     *     summary="Get all ISBN codes",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/IsbnCode")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $isbnCodes = IsbnCode::all();

        return IsbnCodeResource::collection($isbnCodes);
    }

    /**
     * @OA\Get(
     *     path="/api/isbn_codes/{isbn_code}",
     *     tags={"Isbn Code"},
     *     summary="Get a specific ISBN code",
     *     @OA\Parameter(
     *         name="isbn_code",
     *         in="path",
     *         description="ISBN Code ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/IsbnCode")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(IsbnCode $isbnCode)
    {
        return new IsbnCodeResource($isbnCode);
    }

    public function showByCode($isbnCode)
    {
        $codes = IsbnCode::where('code', $isbnCode)
                        ->first();
    
        return $codes;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/isbn_codes",
     *     tags={"Isbn Code"},
     *     summary="Create a new ISBN code",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/IsbnCode")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="ISBN code created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IsbnCode")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'validated' => 'required|boolean',
        ]);

        $isbnCode = IsbnCode::create($request->all());

        return new IsbnCodeResource($isbnCode);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/isbn_codes/{isbn_code}",
     *     tags={"Isbn Code"},
     *     summary="Update an existing ISBN code",
     *     @OA\Parameter(
     *         name="isbn_code",
     *         in="path",
     *         description="ISBN Code ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/IsbnCode")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ISBN code updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IsbnCode")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, IsbnCode $isbnCode)
    {
        $request->validate([
            'code' => 'required|string',
            'validated' => 'required|boolean',
        ]);


        $isbnCode->fill($request->only([
            'code',
            'validated',
        ]));

        $isbnCode->save();

        return new IsbnCodeResource($isbnCode);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/isbn_codes/{isbn_code}",
     *     tags={"Isbn Code"},
     *     summary="Delete an existing ISBN code",
     *     @OA\Parameter(
     *         name="isbn_code",
     *         in="path",
     *         description="ISBN Code ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ISBN code deleted successfully"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(IsbnCode $isbnCode)
    {
        $isbnCode->books()->update(['isbn_code_id' => null]);
        
        $isbnCode->delete();

        return response()->json(['message' => 'ISBN code deleted successfully']);
    }

   /**
     * @OA\Get(
     *     path="/api/auth/isbn_codes/search/{isbn_code}",
     *     tags={"Isbn Code"},
     *     summary="Search a book with an ISBN code",
     *     @OA\Parameter(
     *         name="isbn_code",
     *         in="path",
     *         description="ISBN Code",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book found",
     *         @OA\MediaType(mediaType="application/json")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *    security={
     *        {"Bearer": {}}
     *   }
     * )
     */
    public function search(string $isbnCode)
    {
        $isbnCodeTest = IsbnCode::where('code', $isbnCode)->first();

        if ($isbnCodeTest) {
            $book = Book::where('isbn_code_id', $isbnCodeTest->id)
            ->with('bookTags','bookAuthors')
            ->first();

            if ($book) {
                return response()->json([
                    'message' => 'Book found',
                    'book' => $book
                ]);
            }
        }

        $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbnCode;

        $response = Http::withOptions(['verify' => false])->get($url);

        $json = $response->json();

        if ($json['totalItems'] == 0) {
            return response()->json([
                'message' => 'Book not found',
            ]);
        }

        // récupération des données
        $title = $json['items'][0]['volumeInfo']['title'];
        $authors = $json['items'][0]['volumeInfo']['authors'];
        $publishedDate = $json['items'][0]['volumeInfo']['publishedDate'];
        $validated = false;
        $publisher = isset($json['items'][0]['volumeInfo']['publisher']) ? $json['items'][0]['volumeInfo']['publisher'] : null;

        $bookData = [
            'title' => $title,
            'validated' => $validated,
            'parution_date' => $publishedDate,
        ];

        if ($publisher) {
            $editorTest = Editor::where('editor_name', $publisher)->first();
            if (!$editorTest) {
                $editorTest = Editor::create([
                    'editor_name' => $publisher,
                ]);
            }
            $bookData['editor_id'] = $editorTest->id;
        }

        // Traitement des auteurs
        $authorsData = [];
        foreach ($authors as $author) {
            $authorData = explode(' ', $author);
            $authorTest = Author::where('firstname', $authorData[0])->where('lastname', $authorData[1])->first();
            if (!$authorTest) {
                $authorTest = Author::create([
                    'firstname' => $authorData[0],
                    'lastname' => $authorData[1]
                ]);
            }
            $authorsData[] = $authorTest;
        }
        $bookData['authors'] = $authorsData;

        return response()->json([
            'message' => 'Book found',
            'book' => $bookData,
            'authors' => '$authorsData'
        ]);
    }
}
