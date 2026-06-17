<?php

namespace App\Exceptions;

use Exception;

class SocialApiException extends Exception
{
    protected string $serviceName;

    /**
     * Set nama service yang error (Instagram, Facebook, dll).
     */
    public function setServiceName(string $name): self
    {
        $this->serviceName = $name;
        return $this;
    }

    public function getServiceName(): string
    {
        return $this->serviceName ?? 'Social Media';
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        // Kirim log khusus ke file social_errors.log
        \Log::channel('social_errors')->error("{$this->serviceName} API Error: " . $this->getMessage());
    }
}
