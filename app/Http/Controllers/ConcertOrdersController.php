<?php

namespace App\Http\Controllers;

use App\Billing\Contracts\PaymentGateway;
use App\Models\Concert;
use Illuminate\Http\Request;

class ConcertOrdersController extends Controller
{

    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($concertId, Request $request)
    {
        $concert = Concert::published()->findOrFail($concertId);

        $this->paymentGateway->charge($request->ticket_quantity * $concert->ticket_price, $request->payment_token);

        $order = $concert->orderTickets($request->email, $request->ticket_quantity);

        return response()->json([], 201);
    }
}
