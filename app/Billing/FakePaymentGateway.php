<?php

namespace App\Billing;

use App\Billing\Contracts\PaymentGateway;

class FakePaymentGateway implements PaymentGateway
{

    protected $charges;

    public function __construct()
    {
        $this->charges = collect();
    }

    public function getValidTestToken()
    {
        return 'valid-token';
    }

    public function totalCharges()
    {
        return $this->charges->sum();
    }

    public function charge($amount, $token)
    {
        return $this->charges[] = $amount;
    }
}
