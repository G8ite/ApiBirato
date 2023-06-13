<?php

namespace App\Http\Controllers;

use App\Models\IsbnCode;
use App\Http\Resources\IsbnCodeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\BookResource;
use App\Models\Book;
use GuzzleHttp\Promise\Is;

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
     *     path="/api/isbn_codes/search/{isbn_code}",
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
     *     )
     * )
     */
    public function search(string $isbnCode)
    {

        $isbnCodeTest = IsbnCode::where('code', $isbnCode)->first();

        if ($isbnCodeTest) {
            return new BookResource($isbnCodeTest->book);
        }


        $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:'. $isbnCode;

        $response = Http::withOptions(['verify' => false])->get($url);

        $json = $response->json();

        // récupération des données
        $title = $json['items'][0]['volumeInfo']['title'];
        $authors = $json['items'][0]['volumeInfo']['authors'];
        // pour chaque auteur, on vérifie s'il existe en base de données
        // foreach ($authors as $author) {
        //     // division de la chaîne de caractères en tableau
        //     $author = explode(' ', $author);

        //     $authorFirstNameTest = Author::where('firstname', $author[0])->first();
        //     $authorLastNameTest = Author::where('lastname', $author[1])->first();
        //     // si l'auteur n'existe pas, on le crée
        //     if (!$authorFirstNameTest && !$authorLastNameTest) {
        //         $authorTest = Author::create(['name' => $author]);
        //     }
        //     // on récupère l'id de l'auteur
        //     $authorId = $authorTest->id;
        //     // on crée une entrée dans la table pivot
        //     $authorBook = AuthorBook::create(['author_id' => $authorId]);
        // }
        $publishedDate = $json['items'][0]['volumeInfo']['publishedDate'];
        $validated = false;
        $publisher = $json['items'][0]['volumeInfo']['publisher'];

        // on crée le livre
        $book = Book::create([
            'title' => $title,
            'validated' => $validated,
            'author_id' => 1,
            'parution_date' => $publishedDate,
            'validated' => $validated,
            'editor_id' => 1,
        ]);

        // on crée le code ISBN
        $isbnCode = IsbnCode::create([
            'code' => $isbnCode,
            'validated' => $validated,
            'book_id' => $book->id,
        ]);

        $book->isbn_code_id = $isbnCode->id;
        $book->save();

        return new BookResource($book);       
    }
}
