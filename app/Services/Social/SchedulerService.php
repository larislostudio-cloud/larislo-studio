<?php

namespace App\Services\Social;

use App\Jobs\Social\PublishInstagramPostJob;
use App\Jobs\Social\PublishFacebookPostJob;
use App\Models\ScheduledPost;

class SchedulerService
{
    public function dispatchPost(ScheduledPost $post)
    {
        // Tentukan platform dan dispatch Job yang sesuai
        switch ($post->platform) {
            case 'instagram':
                PublishInstagramPostJob::dispatch($post->id);
                break;
            case 'facebook':
                PublishFacebookPostJob::dispatch($post->id);
                break;
            case 'tiktok':
                // PublishTikTokPostJob::dispatch($post->id);
                break;
        }

        return true;
    }
}
