<?php

namespace App\Jobs\AI;

use App\Models\AiContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $script;

    /**
     * Batas waktu retry (detik). Video butuh waktu lama.
     */
    public $timeout = 300;

    public function __construct($userId, string $script)
    {
        $this->userId = $userId;
        $this->script = $script;
    }

    public function handle(): void
    {
        try {
            // TODO: Integrasi dengan Replicate AI atau HeyGen API

            // Simulasi proses render
            sleep(10);

            $videoUrl = 'https://example.com/sample-video.mp4';

            // Update atau Buat record
            AiContent::create([
                'user_id' => $this->userId,
                'type'    => 'video',
                'prompt'  => $this->script,
                'result'  => $videoUrl,
            ]);

        } catch (\Exception $e) {
            Log::error('GenerateVideoJob Failed: ' . $e->getMessage());
        }
    }
}
