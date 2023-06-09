<?php

namespace App\Http\Controllers;

use App\Models\IsbnCode;
use App\Http\Resources\IsbnCodeResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Isbn Code")
 */
class IsbnCodeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/isbn-codes",
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
     *     path="/api/isbn-codes/{isbnCode}",
     *     tags={"Isbn Code"},
     *     summary="Get a specific ISBN code",
     *     @OA\Parameter(
     *         name="isbnCode",
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
     *     path="/api/auth/isbn-codes",
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
     *     path="/api/admin-only/isbn-codes/{isbnCode}",
     *     tags={"Isbn Code"},
     *     summary="Update an existing ISBN code",
     *     @OA\Parameter(
     *         name="isbnCode",
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
     *     path="/api/admin-only/isbn-codes/{isbnCode}",
     *     tags={"Isbn Code"},
     *     summary="Delete an existing ISBN code",
     *     @OA\Parameter(
     *         name="isbnCode",
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
}
