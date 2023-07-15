<?php

namespace App\Http\Controllers;

use App\Models\UserBook;
use App\Http\Resources\UserBookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserBookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user_books",
     *     tags={"UserBook"},
     *     summary="Get all UserBook",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *            @OA\Property(property="user_books", type="array", @OA\Items(ref="#/components/schemas/UserBook"))
     *         ),
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $userBooks = UserBook::all();
        return UserBookResource::collection($userBooks);
    }

    /**
     * @OA\Get(
     *     path="/api/user_books/{user_book}",
     *     tags={"UserBook"},
     *     summary="Get a user book by ID",
     *     @OA\Parameter(
     *         name="user_book",
     *         in="path",
     *         required=true,
     *         description="User Book ID",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              @OA\Property(property="user_book", ref="#/components/schemas/UserBook")
     *          ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User Book not found",
   *           @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(UserBook $userBook)
    {
        return new UserBookResource($userBook);
    }

    public function showLast(UserBook $userBook)
    {
        $userbooks = UserBook::with('book','book.bookTags','book.bookAuthors')
                        ->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
        
        return UserBookResource::collection($userbooks);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/user_books",
     *     tags={"UserBook"},
     *     summary="Create a new user book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="book_id", type="integer"),
     *             @OA\Property(property="comments", type="string"),
     *             @OA\Property(property="purchase_price", type="number"),
     *             @OA\Property(property="selling_price", type="number"),
     *             @OA\Property(property="purchase_date", type="string", format="date"),
     *             @OA\Property(property="on_sale_date", type="string", format="date"),
     *             @OA\Property(property="sold_date", type="string", format="date"),
     *             @OA\Property(property="conservation_state_id", type="integer"),
     *             @OA\Property(property="status_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserBook"),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'comments' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'nullable|numeric',
            'purchase_date' => 'required|date',
            'on_sale_date' => 'nullable|date',
            'sold_date' => 'nullable|date',
            'conservation_state_id' => 'required|exists:conservation_states,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userBook = UserBook::create($request->all());

        return new UserBookResource($userBook);
    }

    /**
     * @OA\Put(
     *     path="/api/auth/user_books/{user_book}",
     *     tags={"UserBook"},
     *     summary="Update a user book",
     *     @OA\Parameter(
     *         name="user_book",
     *         in="path",
     *         description="User Book ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="book_id", type="integer"),
     *             @OA\Property(property="comments", type="string"),
     *             @OA\Property(property="purchase_price", type="number"),
     *             @OA\Property(property="selling_price", type="number"),
     *             @OA\Property(property="purchase_date", type="string", format="date"),
     *             @OA\Property(property="on_sale_date", type="string", format="date"),
     *             @OA\Property(property="sold_date", type="string", format="date"),
     *             @OA\Property(property="conservation_state_id", type="integer"),
     *             @OA\Property(property="status_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User Book updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/UserBook"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, UserBook $userBook)
    {
        $authenticatedUser = JWTAuth::parseToken()->authenticate();

        if ($authenticatedUser && $userBook->user_id != $authenticatedUser->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|exists:users,id',
            'book_id' => 'sometimes|required|exists:books,id',
            'comments' => 'nullable|string',
            'purchase_price' => 'sometimes|required|numeric',
            'selling_price' => 'nullable|numeric',
            'purchase_date' => 'sometimes|required|date',
            'on_sale_date' => 'nullable|date',
            'sold_date' => 'nullable|date',
            'conservation_state_id' => 'sometimes|required|exists:conservation_states,id',
            'status_id' => 'sometimes|required|exists:statuses,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userBook->update($request->all());
        return new UserBookResource($userBook);
    }
   

    /**
     * @OA\Delete(
     *     path="/api/auth/user_books/{user_book}",
     *     tags={"UserBook"}, 
     *     summary="Delete a user book",
     *     @OA\Parameter(
     *         name="user_book",
     *         in="path",
     *         description="User Book ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User Book deleted successfully",
     *        
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User Book not found",
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(UserBook $userBook)
    {

        $authenticatedUser = JWTAuth::parseToken()->authenticate();

        if ($authenticatedUser && $userBook->user_id != $authenticatedUser->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userBook->delete();

        return response()->json("User Book deleted successfully");
    }
}
