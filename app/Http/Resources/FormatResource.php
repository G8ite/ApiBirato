<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'format_name' => $this->format_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

