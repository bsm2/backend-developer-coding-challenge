<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image_url ? asset(Storage::url($this->image_url)): null,
            'status' => $this->status,
            'platforms' => $this->platforms,
            'scheduled_time' => $this->scheduled_time
        ];
    }
}
