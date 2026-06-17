<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class VideoGeneratorService
{
    // Menggunakan service lain seperti Replicate atau HeyGen
    public function generate(string $script)
    {
        // TODO: Implementasi API Replicate/HeyGen
        // Return URL video atau Job ID
        return 'https://example.com/video.mp4';
    }
}
