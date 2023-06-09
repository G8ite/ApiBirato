<?php

namespace App\Http\Controllers;

use App\Models\Format;
use Illuminate\Http\Request;

class FormatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/formats",
     *     tags={"Formats"},
     *     summary="Get all formats",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="formats", type="array", @OA\Items(ref="#/components/schemas/Format"))
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $formats = Format::all();

        return response()->json(['formats' => $formats]);
    }

    /**
     * @OA\Post(
     *     path="/api/formats",
     *     tags={"Formats"},
     *     summary="Create a new format",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="format_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Format created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="format", ref="#/components/schemas/Format")
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
    public function store(Request $request)
    {
        $request->validate([
            'format_name' => 'required|string',
        ]);

        $format = Format::create($request->all());

        return response()->json(['format' => $format], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/formats/{format}",
     *     tags={"Formats"},
     *     summary="Get a specific format",
     *     @OA\Parameter(
     *         name="format",
     *         in="path",
     *         required=true,
     *         description="Format ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="format", ref="#/components/schemas/Format")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Format not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(Format $format)
    {
        return response()->json(['format' => $format]);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/formats/{format}",
     *     tags={"Formats"},
     *     summary="Update a format",
     *     @OA\Parameter(
     *         name="format",
     *         in="path",
     *         required=true,
     *         description="Format ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="format_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Format updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="format", ref="#/components/schemas/Format")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Format not found",
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
    public function update(Request $request, Format $format)
    {
        $request->validate([
            'format_name' => 'required|string',
        ]);

        $format->update($request->all());

        return response()->json(['format' => $format]);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/formats/{format}",
     *     tags={"Formats"},
     *     summary="Delete a format",
     *     @OA\Parameter(
     *         name="format",
     *         in="path",
     *         required=true,
     *         description="Format ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Format deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Format not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(Format $format)
    {
        $format->delete();

        return response()->json(['message' => 'Format deleted successfully']);
    }
}
