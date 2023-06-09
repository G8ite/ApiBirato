<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Book",
 *     required={"title", "validated", "author_id", "editor_id"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="parution_date", type="string"),
 *     @OA\Property(property="validated", type="boolean"),
 *     @OA\Property(property="author_id", type="integer", example=1),
 *     @OA\Property(property="book_cover_id", type="integer", example=1),
 *     @OA\Property(property="paper_type_id", type="integer", example=1),
 *     @OA\Property(property="format_id", type="integer", example=1),
 *     @OA\Property(property="isbn_code_id", type="integer", example=1),
 *     @OA\Property(property="editor_id", type="integer", example=1),
 *     @OA\Property(property="tags", type="array", @OA\Items(type="integer")),
 * )
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'parution_date',
        'validated',
        'author_id',
        'book_cover_id',
        'paper_type_id',
        'format_id',
        'isbn_code_id',
        'editor',
        'tags'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }


    public function bookCover()
    {
        return $this->belongsTo(BookCover::class, 'book_cover_id');
    }

    public function paperType()
    {
        return $this->belongsTo(PaperType::class, 'paper_type_id');
    }


    public function format()
    {
        return $this->belongsTo(Format::class, 'format_id');
    }


    public function isbn()
    {
        return $this->belongsTo(IsbnCode::class, 'isbn_code_id');
    }


    public function editor()
    {
        return $this->belongsTo(Editor::class, 'editor_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'book_tag', 'book_id', 'tag_id');
    }
}
