<?php

use App\Enums\TalkType;
use App\Models\Talk;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertEquals;

it('allows a user update their talks', function () {
    $talk = Talk::factory()->create();

    actingAs($talk->author)
        ->patch(route('talks.update', ['talk' => $talk]), [
            'title' => 'New title',
            'type' => TalkType::KEYNOTE->value,
            'length' => 50,
        ])
        ->assertSessionDoesntHaveErrors();

    assertEquals('New title', $talk->refresh()->title);
    assertEquals(TalkType::KEYNOTE, $talk->type);
    assertEquals('50', $talk->length);
});

it('doesnt allow a user update other user talks', function () {
    $talk = Talk::factory()->create();

    actingAs(User::factory()->create())
        ->patch(route('talks.update', ['talk' => $talk]), [

        ])
        ->assertForbidden();
});
