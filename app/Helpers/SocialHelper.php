<?php

namespace App\Helpers;

class SocialHelper
{
    /**
     * Daftar platform yang didukung.
     *
     * @return array
     */
    public static function getSupportedPlatforms(): array
    {
        return [
            'instagram' => 'Instagram',
            'facebook' => 'Facebook Page',
            'tiktok' => 'TikTok',
            'twitter' => 'X (Twitter)',
            'linkedin' => 'LinkedIn',
        ];
    }

    /**
     * Dapatkan limit karakter per platform.
     *
     * @param string $platform
     * @return int
     */
    public static function getCharacterLimit(string $platform): int
    {
        return match ($platform) {
            'twitter' => 280,
            'instagram' => 2200,
            'facebook' => 63206,
            'linkedin' => 3000,
            'tiktok' => 2200,
            default => 1000,
        };
    }

    /**
     * Hitung estimasi waktu posting terbaik berdasarkan platform.
     * (Ini adalah rule-of-thumb sederhana, bisa dikembangkan dengan AI Analytics).
     *
     * @param string $platform
     * @return string Jam dalam format H:i
     */
    public static function suggestBestTime(string $platform): string
    {
        // Data dummy statistik umum
        $bestTimes = [
            'instagram' => '18:00', // Saat orang pulang kerja
            'facebook' => '13:00', // Saat lunch break
            'tiktok' => '21:00', // Saat malam sebelum tidur
            'twitter' => '12:00',
            'linkedin' => '08:00', // Saat mulai kerja
        ];

        return $bestTimes[$platform] ?? '12:00';
    }

    /**
     * Format konten teks agar sesuai dengan platform.
     * (Misal: menambah jarak paragraf untuk Instagram, memotong untuk Twitter).
     *
     * @param string $text
     * @param string $platform
     * @return string
     */
    public static function formatContent(string $text, string $platform): string
    {
        // Jika Twitter dan melebihi limit, tambahkan "..."
        if ($platform === 'twitter' && strlen($text) > 280) {
            return substr($text, 0, 277) . '...';
        }

        // Jika Instagram, pastikan ada emoji dan spasi yang baik
        if ($platform === 'instagram') {
            return nl2br($text);
        }

        return $text;
    }
}
