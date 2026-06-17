<?php

namespace App\Jobs\Social;

use App\Models\ScheduledPost;
use App\Models\SocialAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublishFacebookPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function handle(): void
    {
        $post = ScheduledPost::find($this->postId);
        $account = SocialAccount::where('user_id', $post->user_id)->where('platform', 'facebook')->first();

        if (!$post || !$account) return;

        try {
            // Facebook Page Feed API
            $endpoint = 'https://graph.facebook.com/v19.0/' . $account->provider_id . '/photos'; // Untuk foto

            $response = Http::asForm()->post($endpoint, [
                'url' => asset('storage/' . $post->media_path),
                'caption' => $post->content,
                'access_token' => $account->access_token,
            ]);

            if ($response->successful()) {
                $post->update(['status' => 'published']);
            } else {
                throw new \Exception($response->body());
            }

        } catch (\Exception $e) {
            Log::error('Facebook Publish Failed: ' . $e->getMessage());
            $post->update(['status' => 'failed']);
        }
    }
}
