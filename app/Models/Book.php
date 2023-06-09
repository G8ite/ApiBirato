<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Book",
 *     required={"title", "validated", "id_author", "id_editor"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="parution_date", type="string"),
 *     @OA\Property(property="validated", type="boolean"),
 *     @OA\Property(property="id_author", type="integer", example=1),
 *     @OA\Property(property="id_book_cover", type="integer", example=1),
 *     @OA\Property(property="id_paper_type", type="integer", example=1),
 *     @OA\Property(property="id_format", type="integer", example=1),
 *     @OA\Property(property="id_isbn_code", type="integer", example=1),
 *     @OA\Property(property="id_editor", type="integer", example=1),
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
        'id_author',
        'id_book_cover',
        'id_paper_type',
        'id_format',
        'id_isbn_code',
        'id_editor',
        'tags'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'id_author');
    }


    public function bookCover()
    {
        return $this->belongsTo(BookCover::class, 'id_book_cover');
    }

    public function paperType()
    {
        return $this->belongsTo(PaperType::class, 'id_paper_type');
    }


    public function format()
    {
        return $this->belongsTo(Format::class, 'id_format');
    }


    public function isbn()
    {
        return $this->belongsTo(IsbnCode::class, 'id_isbn_code');
    }


    public function editor()
    {
        return $this->belongsTo(Editor::class, 'id_editor');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'book_tag', 'id_book', 'id_tag');
    }
}
