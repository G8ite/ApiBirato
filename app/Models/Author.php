<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Author",
 *     title="Author",
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="name", type="string", example="John"),
 *     @OA\Property(property="surname", type="string", example="Doe"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
