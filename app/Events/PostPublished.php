<?php

namespace App\Events;

use App\Models\ScheduledPost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostPublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Instance post yang berhasil dipublikasikan.
     *
     * @var \App\Models\ScheduledPost
     */
    public $post;

    /**
     * Create a new event instance.
     */
    public function __construct(ScheduledPost $post)
    {
        $this->post = $post;
    }
}
