<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'platform'   => ucfirst($this->platform),
            'content'    => $this->content,
            'status'     => $this->status,
            'media_url'  => $this->media_path ? asset('storage/' . $this->media_path) : null,
            'scheduled_for' => $this->publish_at->format('d M Y H:i'),
        ];
    }
}
