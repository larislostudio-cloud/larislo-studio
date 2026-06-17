<?php

namespace App\Events;

use App\Models\AiContent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AIContentGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Instance konten AI yang baru dihasilkan.
     *
     * @var \App\Models\AiContent
     */
    public $aiContent;

    /**
     * Create a new event instance.
     */
    public function __construct(AiContent $aiContent)
    {
        $this->aiContent = $aiContent;
    }
}
