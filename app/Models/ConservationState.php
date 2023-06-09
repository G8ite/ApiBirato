<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="ConservationState",
 *     description="Conservation State model",
 *     required={"state_name"},
 *     @OA\Property(
 *        property="id",
 *        type="integer",
 *        readOnly=true
 *     ),
 *     @OA\Property(
 *        property="state_name",
 *        type="string",
 *        description="Name of the conservation state"
 *     ),
 *     @OA\Property(
 *        property="created_at",
 *        type="string",
 *        format="date-time",
 *        readOnly=true
 *     ),
 *     @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        format="date-time",
 *        readOnly=true
 *     )
 * )
 */
class ConservationState extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_name',
    ];
}
