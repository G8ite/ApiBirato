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
            'id_author' => $this->id_author,
            'id_book_cover' => $this->id_book_cover,
            'id_paper_type' => $this->id_paper_type,
            'id_format' => $this->id_format,
            'id_isbn_code' => $this->id_isbn_code,
            'id_editor' => $this->id_editor,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
