<?php

namespace App\Console\Commands;

use App\Models\ScheduledPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    /**
     * Nama signature command untuk dipanggil di terminal.
     *
     * @var string
     */
    protected $signature = 'posts:publish';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts to social media platforms';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to check for scheduled posts...');

        // 1. Ambil post yang statusnya 'scheduled' dan waktunya sudah lewat atau sama dengan sekarang
        $posts = ScheduledPost::where('status', 'scheduled')
            ->where('publish_at', '<=', now())
            ->get();

        if ($posts->isEmpty()) {
            $this->info('No posts to publish at this time.');
            return;
        }

        foreach ($posts as $post) {
            $this->info("Publishing Post ID: {$post->id} to {$post->platform}");

            try {
                // 2. Logic Publishing (Placeholder)
                // Di sini Anda bisa menambahkan Switch Case untuk memanggil Service API masing-masing platform
                // Contoh: match($post->platform) { 'instagram' => InstagramService::post($post), ... }

                $publishResult = $this->mockPublish($post);

                if ($publishResult) {
                    // 3. Update status menjadi 'published' jika sukses
                    $post->update(['status' => 'published']);
                    $this->info("Post ID: {$post->id} successfully published.");
                } else {
                    throw new \Exception('API returned false.');
                }

            } catch (\Exception $e) {
                // 4. Tangani jika gagal
                $post->update(['status' => 'failed']);
                Log::error("Failed to publish post ID {$post->id}: " . $e->getMessage());
                $this->error("Failed to publish Post ID: {$post->id}");
            }
        }

        $this->info('Publishing process completed.');
    }

    /**
     * Mock function untuk simulasi publishing.
     * Ganti ini dengan integrasi API asli (Meta, TikTok, dll).
     */
    private function mockPublish(ScheduledPost $post): bool
    {
        // Simulasi delay network
        sleep(1);
        // Simulasi sukses (90% chance)
        return rand(1, 10) > 1;
    }
}
