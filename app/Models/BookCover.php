<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="BookCover",
 *     description="Book cover model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="book_cover_name",
 *         type="string",
 *         example="Cover 1"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time"
 *     )
 * )
 */
class BookCover extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_cover_name',
    ];
}
