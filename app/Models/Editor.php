<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Editor",
 *     required={"editor_name"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="editor_name", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */
class Editor extends Model
{
    use HasFactory;

    protected $fillable = [
        'editor_name',
    ];
}
