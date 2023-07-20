<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaperTypeResource;
use App\Models\PaperType;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Paper Type",
 * )
 */
class PaperTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/paper_types",
     *     tags={"Paper Type"},
     *     summary="Get all paper types",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PaperType")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $paperTypes = PaperType::all();

        return PaperTypeResource::collection($paperTypes);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/paper_types",
     *     tags={"Paper Type"},
     *     summary="Create a new paper type",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"paper_type_name"},
     *             @OA\Property(property="paper_type_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PaperType")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'paper_type_name' => 'required|string',
        ]);

        $paperType = PaperType::create($request->all());

        return new PaperTypeResource($paperType);
    }

    /**
     * @OA\Get(
     *     path="/api/paper_types/{paper_type}",
     *     tags={"Paper Type"},
     *     summary="Get a specific paper type",
     *     @OA\Parameter(
     *         name="paper_type",
     *         in="path",
     *         description="ID of the paper type",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PaperType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paper type not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(PaperType $paper_type)
    {
        return new PaperTypeResource($paper_type);
    }

    public function showByPaperTypeName($name) {
        $papertypes = PaperType::where('paper_type_name', $name)
                        ->first();
    
        return $papertypes;
    }
    /**
     * @OA\Put(
     *     path="/api/admin-only/paper_types/{paper_type}",
     *     tags={"Paper Type"},
     *     summary="Update a specific paper type",
     *     @OA\Parameter(
     *         name="paper_type",
     *         in="path",
     *         description="ID of the paper type",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"paper_type_name"},
     *             @OA\Property(property="paper_type_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PaperType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paper type not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, PaperType $paper_type)
    {
        $request->validate([
            'paper_type_name' => 'required|string',
        ]);

        $paper_type->update($request->all());

        return new PaperTypeResource($paper_type);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/paper_types/{paper_type}",
     *     tags={"Paper Type"},
     *     summary="Delete a specific paper type",
     *     @OA\Parameter(
     *         name="paper_type",
     *         in="path",
     *         description="ID of the paper type",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paper type not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(PaperType $paper_type)
    {
        $paper_type->books()->update(['paper_type_id' => null]);

        $paper_type->delete();

        return response()->json(['message' => 'Paper type deleted successfully']);
    }
}
