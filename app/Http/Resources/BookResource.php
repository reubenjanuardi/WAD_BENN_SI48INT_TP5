<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * =========1=========
     * Transform the resource into an array.
     * Make sure to inclue all Book model attributes.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'author'=>$this->author,
            'published_year'=>$this->published_year,
            'is_available'=>$this->is_available
        ];
    }
}
