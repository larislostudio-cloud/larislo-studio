<?php

namespace App\Jobs\AI;

use App\Helpers\AiHelper;
use App\Models\AiContent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateCaptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, array $data)
    {
        $this->userId = $userId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Panggil Helper untuk generate
            $result = AiHelper::generateCaption($this->data);

            if ($result) {
                // Simpan hasil ke database
                AiContent::create([
                    'user_id' => $this->userId,
                    'type'    => 'caption',
                    'prompt'  => json_encode($this->data),
                    'result'  => $result,
                ]);

                // TODO: Kirim notifikasi ke user (misal via email atau broadcast)
            }
        } catch (\Exception $e) {
            Log::error('GenerateCaptionJob Failed: ' . $e->getMessage());
            // Job akan otomatis di-retry jika dikonfigurasi
        }
    }
}
