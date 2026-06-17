<?php

namespace App\Exceptions;

use Exception;

class AiGenerationException extends Exception
{
    public function __construct(string $type = "content", string $reason = "Unknown error")
    {
        $message = "Failed to generate AI {$type}. Reason: {$reason}";
        parent::__construct($message);
    }
}
