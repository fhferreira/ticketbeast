<?php

namespace Tests\Feature;

use App\Billing\Contracts\PaymentGateway;
use App\Billing\FakePaymentGateway;
use App\Models\Concert;
use Carbon\Carbon;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase as TestCase;

class PurchaseTicketsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function customer_can_purchase_concert_tickets()
    {

        $paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $paymentGateway);


        // Arrange
        // Create a concert
        $concert = factory(Concert::class)->state('published')->create([
            'ticket_price' => 3250
        ]);

        // Act
        // Purchase concert tickets
        $response = $this->json('POST', "/concerts/{$concert->id}/orders", [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(201);

        // Assert
        // Make sure the customer was charged the correct amount
        // Make sure that an order exists for this customer
        $this->assertEquals(9750, $paymentGateway->totalCharges());

        $order = $concert->orders()->where("email", "john@example.com")->first();

        $this->assertNotNull($order);

        $this->assertEquals(3, $order->tickets->count());
    }
}
