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

class PublishTikTokPostJob implements ShouldQueue
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
        $account = SocialAccount::where('user_id', $post->user_id)->where('platform', 'tiktok')->first();

        if (!$post || !$account) return;

        try {
            // TikTok Video Upload API (Logic sederhana)
            // TikTok biasanya memerlukan upload file binary, bukan sekedar URL.

            $videoPath = storage_path('app/public/' . $post->media_path);

            // $response = TikTokService::upload($account->access_token, $videoPath, $post->content);

            // Simulasi Sukses
            Log::info("Publishing to TikTok for Post ID: " . $this->postId);

            $post->update(['status' => 'published']);

        } catch (\Exception $e) {
            Log::error('TikTok Publish Failed: ' . $e->getMessage());
            $post->update(['status' => 'failed']);
        }
    }
}
