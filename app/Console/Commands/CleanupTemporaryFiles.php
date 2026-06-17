<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CleanupTemporaryFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:temporary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old files from temporary storage folders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting temporary file cleanup...');

        $directory = 'temporary'; // Path relatif terhadap storage/app
        $disk = Storage::disk('local'); // Menggunakan disk local (storage/app)

        // Cek apakah folder ada
        if (!$disk->exists($directory)) {
            $this->warn('Temporary directory does not exist.');
            return;
        }

        $files = $disk->files($directory);
        $deletedCount = 0;

        // Batas waktu file dianggap sampah (misal: lebih dari 1 hari yang lalu)
        $expirationTime = now()->subDay()->timestamp;

        foreach ($files as $file) {
            // Ambil waktu modifikasi terakhir file
            $lastModified = $disk->lastModified($file);

            if ($lastModified < $expirationTime) {
                $disk->delete($file);
                $deletedCount++;
            }
        }

        $this->info("Cleanup complete. Deleted {$deletedCount} files.");
    }
}
