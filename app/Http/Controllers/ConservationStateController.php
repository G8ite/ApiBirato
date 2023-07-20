<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConservationStateResource;
use App\Models\ConservationState;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Conservation State",
 *     description=""
 * )
 */
class ConservationStateController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/conservation_states",
     *     tags={"Conservation State"},
     *     summary="Get all conservation states",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ConservationState")
     *        )    
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function index()
    {
        $conservation_states = ConservationState::all();

        return ConservationStateResource::collection($conservation_states);
    }

    /**
     * @OA\Get(
     *     path="/api/conservation_states/{conservation_state}",
     *     tags={"Conservation State"},
     *     summary="Get a specific conservation state",
     *      @OA\Parameter(
     *         name="conservation_state",
     *         in="path",
     *         description="ID of the conservation state",
     *         required=true,
     *         @OA\Schema(
     *         type="integer",
     *         format="int64",
     *         example=1)
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConservationState")
     *     ),
     *     @OA\Response(
     *        response=404,
     *       description="Conservation state not found"
     *    ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function show(ConservationState $conservation_state)
    {
        return new ConservationStateResource($conservation_state);
    }

    public function showByStateName($name) {
        $states = ConservationState::where('state_name', $name)
                        ->first();
        return $states;
    }
    /**
     * @OA\Post(
     *     path="/api/admin-only/conservation_states",
     *     tags={"Conservation State"},
     *     summary="Create a new conservation state",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"state_name"},
     *              @OA\Property(property="state_name", type="string")
     *       )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConservationState")
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'state_name' => 'required|string',
        ]);

        $conservationState = ConservationState::create($request->all());

        return new ConservationStateResource($conservationState);
    }

    /**
     * @OA\Put(
     *     path="/api/admin-only/conservation_states/{conservation_state}",
     *     tags={"Conservation State"},
     *     summary="Update a conservation state",
     *      @OA\Parameter(
     *         name="conservation_state",
     *         in="path",
     *         description="ID of the conservation state",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"state_name"},
     *              @OA\Property(property="state_name", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ConservationState")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Conservation state not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function update(Request $request, ConservationState $conservation_state)
    {
        $request->validate([
            'state_name' => 'required|string',
        ]);

        $conservation_state->update($request->all());

        return new ConservationStateResource($conservation_state);
    }

    /**
     * @OA\Delete(
     *     path="/api/admin-only/conservation_states/{conservation_state}",
     *     tags={"Conservation State"},
     *     summary="Delete a conservation state",
     *     @OA\Parameter(
     *         name="conservation_state",
     *         in="path",
     *         description="ID of the conservation state",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Conservation state deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Conservation state not found"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function delete(ConservationState $conservation_state)
    {
        $conservation_state->delete();

        return response()->json(['message' => 'Conservation state deleted successfully']);
    }
}
