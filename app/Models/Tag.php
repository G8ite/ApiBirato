<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * @OA\Schema(
     *     schema="Tag",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="tag_name", type="string")
     * )
     */

    protected $fillable = [
        'tag_name',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_tag', 'tag_id', 'book_id');
    }

}
