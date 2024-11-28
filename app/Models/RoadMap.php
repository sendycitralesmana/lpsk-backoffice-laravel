<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadMap extends Model
{

    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'roadmaps';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(RoadMapDocuments::class, 'roadmap_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoadMapImages::class, 'roadmap_id', 'id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(RoadMapVideos::class, 'roadmap_id', 'id');
    }
    
    // set createdAt to format
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->locale('id')->isoFormat('dddd, D MMMM YYYY');
    }

    // set updatedAt to format
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->locale('id')->isoFormat('dddd, D MMMM YYYY');
    }

}
