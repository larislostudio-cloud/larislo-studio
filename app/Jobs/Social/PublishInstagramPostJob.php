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

class PublishInstagramPostJob implements ShouldQueue
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

        if (!$post || $post->status !== 'scheduled') {
            return;
        }

        // Ambil token user (asumsi ada model SocialAccount)
        $account = SocialAccount::where('user_id', $post->user_id)
                                ->where('platform', 'instagram')
                                ->first();

        if (!$account) {
            $post->update(['status' => 'failed', 'notes' => 'No account connected']);
            return;
        }

        try {
            // Logic Publishing ke Instagram Graph API
            // Step 1: Create Media Container
            $response = Http::get('https://graph.facebook.com/v19.0/' . $account->provider_id . '/media', [
                'image_url' => asset('storage/' . $post->media_path), // URL Publik gambar
                'caption'   => $post->content,
                'access_token' => $account->access_token,
            ]);

            $creationId = $response->json('id');

            // Step 2: Publish Container
            Http::post('https://graph.facebook.com/v19.0/' . $account->provider_id . '/media_publish', [
                'creation_id' => $creationId,
                'access_token' => $account->access_token,
            ]);

            $post->update(['status' => 'published']);

        } catch (\Exception $e) {
            Log::error('Instagram Publish Failed: ' . $e->getMessage());
            $post->update(['status' => 'failed', 'notes' => $e->getMessage()]);
        }
    }
}
