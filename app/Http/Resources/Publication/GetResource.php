<?php

namespace App\Http\Resources\Publication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetResource extends JsonResource
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
            'publication_category_id' => $this->publication_category_id,
            'publication_category' => $this->publicationCategory,
            'title' => $this->title,
            'description' => $this->description,
            'document_name' => $this->document_name,
            'document_url' => $this->document_url,
            'cover' => $this->cover,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
