<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tags' => TagResource::collection($this->whenLoaded('bookTags')),
            'authors' => AuthorResource::collection($this->whenLoaded('bookAuthors')),
        ];
    }
}
