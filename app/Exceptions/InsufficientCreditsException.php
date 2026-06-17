<?php

namespace App\Exceptions;

use Exception;

class InsufficientCreditsException extends Exception
{
    protected $code = 402; // HTTP Payment Required

    /**
     * Mendapatkan pesan error yang user-friendly.
     */
    public function getLocalizedMessage(): string
    {
        return "Maaf, kredit AI Anda habis. Silakan upgrade paket atau beli kredit tambahan.";
    }
}
