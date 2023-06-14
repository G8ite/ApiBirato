<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="BookWithTagsAndAuthors",
 *     title="Book with Tags and Authors",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="parution_date", type="string"),
 *     @OA\Property(property="validated", type="boolean"),
 *     @OA\Property(property="author_id", type="integer"),
 *     @OA\Property(property="book_cover_id", type="integer"),
 *     @OA\Property(property="paper_type_id", type="integer"),
 *     @OA\Property(property="format_id", type="integer"),
 *     @OA\Property(property="isbn_code_id", type="integer"),
 *     @OA\Property(property="editor_id", type="integer"),
 *     @OA\Property(property="tags", type="array", @OA\Items(ref="#/components/schemas/Tag")),
 *     @OA\Property(property="authors", type="array", @OA\Items(ref="#/components/schemas/Author"))
 * )
 */
class BookWithTagsAndAuthorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'parution_date' => $this->parution_date,
            'validated' => $this->validated,
            'book_cover_id' => $this->book_cover_id,
            'paper_type_id' => $this->paper_type_id,
            'format_id' => $this->format_id,
            'isbn_code_id' => $this->isbn_code_id,
            'editor_id' => $this->editor_id,
            'tags' => TagResource::collection($this->whenLoaded('bookTags')),
            'authors' => AuthorResource::collection($this->whenLoaded('bookAuthors')),
        ];
    }
}
