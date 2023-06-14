<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBookResource extends JsonResource
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
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'comments' => $this->comments,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'purchase_date' => $this->purchase_date,
            'on_sale_date' => $this->on_sale_date,
            'sold_date' => $this->sold_date,
            'conservation_state_id' => $this->conservation_state_id,
            'status_id' => $this->status_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}