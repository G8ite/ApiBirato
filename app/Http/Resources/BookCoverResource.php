<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookCoverResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'book_cover_name' => $this->book_cover_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
