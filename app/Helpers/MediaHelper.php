<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaHelper
{
    /**
     * Upload file ke storage yang ditentukan.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder (contoh: 'ai-images', 'thumbnails')
     * @param string $disk (default: 'public')
     * @return string|null Path file relatif
     */
    public static function uploadFile($file, string $folder)
{
    // Jangan gunakan extension asli. Paksa ekstensi yang aman.
    $extension = $file->getClientOriginalExtension();

    // Validasi extension manual (double check)
    if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'mp4', 'mov'])) {
        return null;
    }

    $fileName = Str::random(40) . '.' . $extension;
    return $file->storeAs($folder, $fileName, 'public');
}
    public static function deleteFile(?string $path, string $disk = 'public')
    {
        if (!$path) {
            return false;
        }

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Dapatkan URL publik dari file.
     *
     * @param string|null $path
     * @return string|null
     */
    public static function getUrl(?string $path)
    {
        if (!$path) {
            return null;
        }

        // Jika disk public, gunakan asset helper
        if (config('filesystems.default') === 'public') {
            return asset('storage/' . $path);
        }

        // Jika s3 atau lainnya, gunakan Storage::url
        return Storage::url($path);
    }
}
