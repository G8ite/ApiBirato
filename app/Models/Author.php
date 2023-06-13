<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Author",
 *     title="Author",
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="firstname", type="string", example="John"),
 *     @OA\Property(property="lastname", type="string", example="Doe"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="books", type="array", @OA\Items(ref="#/components/schemas/Book"))
 * )
 */
class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function bookAuthors()
    {
        return $this->belongsToMany(Book::class, 'book_author', 'author_id', 'book_id');
    }
}
