<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="BookTag",
 *     title="BookTag",
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="book_id", type="integer", example=1),
 *     @OA\Property(property="tag_id", type="integer", example=1),
 * )
 */
class BookTag extends Model
{
    use HasFactory;

    protected $table = 'book_tag';
    protected $fillable = ['book_id', 'tag_id'];
    public $timestamps = false;
}
