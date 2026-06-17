<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AIContentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'type'    => $this->type,
            'prompt'  => $this->prompt,
            'result'  => $this->result, // Asumsi text atau URL gambar
            'created' => $this->created_at->toIso8601String(),
        ];
    }
}
