<?php

namespace Tests\Feature;

use App\Models\Concert;
use Carbon\Carbon;
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\BrowserKitTestCase as TestCase;

class ViewConcertListingBrowserKitTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function user_can_view_a_published_concert_listing()
    {
        // arrange
        // create a concert
        $concert = factory(Concert::class)->state('published')->create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('December 13, 2016 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_information' => 'For tickets, call (555) 555-5555.'
        ]);

        // act
        // view the concert listing
        $response = $this->visit('/concerts/'.$concert->id);

        //$response->dumpHeaders();
        //$response->dumpSession();
        //$response->dump();

        // assert
        // see the concert details
        $response->see('The Red Chord');
        $response->see('with Animosity and Lethargy');
        $response->see('December 13, 2016');
        $response->see('8:00pm');
        $response->see('32.50');
        $response->see('The Mosh Pit');
        $response->see('123 Example Lane');
        $response->see('Laraville');
        $response->see('ON');
        $response->see('17916');
        $response->see('For tickets, call (555) 555-5555.');
    }
}
