<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="IsbnCode",
 *     required={"code", "validated"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="code", type="string"),
 *     @OA\Property(property="validated", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */
class IsbnCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'validated',
    ];
}
