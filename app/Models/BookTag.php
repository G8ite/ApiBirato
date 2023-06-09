<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="BookTag",
 *     title="BookTag",
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="id_book", type="integer", example=1),
 *     @OA\Property(property="id_tag", type="integer", example=1),
 * )
 */
class BookTag extends Model
{
    use HasFactory;

    protected $table = 'book_tag';
    protected $fillable = ['id_book', 'id_tag'];
    public $timestamps = false;
}
