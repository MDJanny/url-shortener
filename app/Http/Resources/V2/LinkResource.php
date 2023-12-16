<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'original_url' => $this->original_url,
            'short_url' => config('app.url').'/'.$this->short_url,
            'hits' => $this->hits,
        ];
    }
}
