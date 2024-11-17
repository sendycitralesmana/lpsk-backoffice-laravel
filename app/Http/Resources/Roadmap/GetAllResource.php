<?php

namespace App\Http\Resources\Roadmap;

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
            'slug' => $this->slug,
            'title' => $this->title,
            'content' => $this->content,
            'cover' => $this->cover,
            'status' => $this->status,
            'documents' => $this->documents,
            'videos' => $this->videos,
            'images' => $this->images,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
