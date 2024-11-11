<?php

namespace App\Http\Resources\News;

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
            'user_id' => $this->user_id,
            'user' => $this->user,
            'news_category_id' => $this->news_category_id,
            'category' => $this->newsCategory,
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
