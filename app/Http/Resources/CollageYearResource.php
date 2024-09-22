<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollageYearResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'collage'=>CollageResource::make($this->whenLoaded('collage')),
            'yaer'=>NameInfoResource::make($this->whenLoaded('yaer')),
        ];
    }
}
