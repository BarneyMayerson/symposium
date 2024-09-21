<?php

use App\Models\Talk;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('shows basic talk details on the show page', function () {
    $talk = Talk::factory()->create();

    actingAs($talk->author)
        ->get(route('talks.show', ['talk' => $talk]))
        ->assertSee($talk->title);
});

it('doesnt show other users talk details on the show page', function () {
    $talk = Talk::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('talks.show', ['talk' => $talk]))
        ->assertForbidden();
});
