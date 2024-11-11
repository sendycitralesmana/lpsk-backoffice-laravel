<?php

namespace App\Http\Resources\Information;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'information_category_id' => $this->information_category_id,
            'information_category' => $this->informationCategory,
            'title' => $this->title,
            'content' => $this->content,
            'cover' => $this->cover,
            'documents' => $this->documents,
            'videos' => $this->videos,
            'images' => $this->images,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
