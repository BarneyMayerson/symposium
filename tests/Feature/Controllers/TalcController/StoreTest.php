<?php

use App\Enums\TalkType;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

it('allows a user create a talk', function () {
    $user = User::factory()->create();

    $validAttributes = [
        'title' => 'Title',
        'length' => '45',
        'type' => TalkType::KEYNOTE,
    ];

    actingAs($user)
        ->post(route('talks.store', $validAttributes));

    assertDatabaseHas('talks', $validAttributes);
});
