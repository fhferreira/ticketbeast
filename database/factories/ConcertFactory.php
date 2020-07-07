<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(\App\Models\Concert::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'subtitle' =>'with The Fake Openers',
        'date' => Carbon::parse("+2 weeks"),
        'ticket_price' => 200 * 100,
        'venue' => 'The Venue',
        'venue_address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'additional_information' => 'For tickets, call (555) 555-5555.',
    ];
});

$factory->state(\App\Models\Concert::class, 'published', function (Faker $faker) {
    return [
        'published_at' => Carbon::parse("+2 weeks"),
    ];
});

$factory->state(\App\Models\Concert::class, 'unpublished', function (Faker $faker) {
    return [
        'published_at' => null,
    ];
});
