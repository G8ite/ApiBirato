<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="PaperType",
 *     description="Paper Type model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the paper type",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="paper_type_name",
 *         type="string",
 *         description="Name of the paper type"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation date and time"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update date and time"
 *     )
 * )
 */
class PaperType extends Model
{
    use HasFactory;

    protected $fillable = [
        'paper_type_name',
    ];
}
