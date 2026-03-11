<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // Customize the response data as needed
        // For example, you can return specific fields or format the data differently
        return [
            'aa' => $this->id,
            'bb' => $this->name,
            'cc' => $this->city,
            'dd' => $this->address, 
        ];
    }
}
