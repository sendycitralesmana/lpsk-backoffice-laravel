<?php

namespace App\Http\Resources\Highlight;

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
            'highlight_category_id' => $this->highlight_category_id,
            'highlight_category' => $this->highlightCategory,
            'news_id' => $this->news_id,
            'news' => $this->news,
            'newsCategory' => $this->news->newsCategory,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
