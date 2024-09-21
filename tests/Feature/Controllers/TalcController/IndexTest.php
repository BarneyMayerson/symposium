<?php

use App\Models\Talk;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('lists talks on the index page', function () {
    $user = User::factory()->create();
    $talk = Talk::factory()->create([
        'user_id' => $user->id,
    ]);

    actingAs($user)->get(route('talks.index'))->assertSee($talk->title);
});

it('cannot lists other users talks on the index page', function () {
    $user = User::factory()->create();
    $talk = Talk::factory()->create();

    actingAs($user)->get(route('talks.index'))->assertDontSee($talk->title);
});
