<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Status")
 */
class StatusController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/statuses",
     *     summary="Get all status",
     *     tags={"Status"},
     *     @OA\Response(
     *         response=200,
     *         description="List of status",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Status")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $status = Status::all();
        return StatusResource::collection($status);
    }

    /**
     * @OA\Get(
     *     path="/api/statuses/{id}",
     *     summary="Get a status by ID",
     *     tags={"Status"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Status ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The status",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Status not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show($id)
    {
        $status = Status::findOrFail($id);
        return new StatusResource($status);
    }

    /**
     * @OA\Post(
     *     path="/api/admin-only/statuses",
     *     summary="Create a new status",
     *     tags={"Status"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The created status",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $status = Status::create($request->all());
        return new StatusResource($status);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/statuses/{id}",
     *     summary="Update a status",
     *     tags={"Status"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Status ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The updated status",
     *         @OA\JsonContent(ref="#/components/schemas/Status")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Status not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, $id)
    {
        $status = Status::findOrFail($id);
        $status->update($request->all());
        return new StatusResource($status);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/statuses/{id}",
     *     summary="Delete a status",
     *     tags={"Status"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Status ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Status not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();
        return response()->json(['message' => 'Status deleted successfully']);
    }
}
