<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoadMapDocuments extends Model
{

    protected $table = 'roadmap_documents';
    protected $guarded = [];

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
