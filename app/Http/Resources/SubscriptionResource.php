<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'price'=> 'Rp ' . number_format($this->price, 0, ',', '.'),
            'features' => [
                'ai_credits' => $this->ai_credits_limit,
                'scheduler'  => (bool) $this->scheduler_enabled,
            ]
        ];
    }
}
