<?php

namespace App\Exceptions;

use Exception;

class PaymentFailedException extends Exception
{
    protected array $paymentData;

    public function __construct(string $message = "Payment processing failed.", array $paymentData = [])
    {
        parent::__construct($message);
        $this->paymentData = $paymentData;
    }

    /**
     * Mendapatkan data konteks error (Order ID, dll).
     */
    public function getContext(): array
    {
        return $this->paymentData;
    }
}
