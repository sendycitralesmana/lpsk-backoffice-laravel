<?php

namespace App\Http\Resources\Setting;

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
            'user_id' => $this->user_id,
            'user' => $this->user,
            'setting_category_id' => $this->setting_category_id,
            'category' => $this->settingCategory,
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
