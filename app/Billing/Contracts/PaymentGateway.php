<?php

namespace App\Billing\Contracts;

interface PaymentGateway
{
    public function charge($amount, $token);
}
