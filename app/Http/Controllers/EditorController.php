<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use App\Http\Resources\EditorResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Editor")
 */
class EditorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/editors",
     *     tags={"Editor"},
     *     summary="Get all editors",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Editor")
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $editors = Editor::all();

        return EditorResource::collection($editors);
    }

    /**
     * @OA\Get(
     *     path="/api/editors/{editor}",
     *     tags={"Editor"},
     *     summary="Get a specific editor",
     *     @OA\Parameter(
     *         name="editor",
     *         in="path",
     *         description="Editor ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Editor")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(Editor $editor)
    {
        return new EditorResource($editor);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/editors",
     *     tags={"Editor"},
     *     summary="Create a new editor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Editor")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Editor created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Editor")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'editor_name' => 'required|string',
        ]);

        $editor = Editor::create($request->all());

        return new EditorResource($editor);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/editors/{editor}",
     *     tags={"Editor"},
     *     summary="Update an existing editor",
     *     @OA\Parameter(
     *         name="editor",
     *         in="path",
     *         description="Editor ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Editor")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Editor updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Editor")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, Editor $editor)
    {
        $request->validate([
            'editor_name' => 'required|string',
        ]);

        $editor->update($request->all());

        return new EditorResource($editor);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/editors/{editor}",
     *     tags={"Editor"},
     *     summary="Delete an existing editor",
     *     @OA\Parameter(
     *         name="editor",
     *         in="path",
     *         description="Editor ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Editor deleted successfully"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(Editor $editor)
    {
        $editor->books()->update(['editor_id' => null]);

        $editor->delete();

        return response()->json(['message' => 'Editor deleted successfully']);
    }
}
