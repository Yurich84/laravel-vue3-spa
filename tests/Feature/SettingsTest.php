<?php

use App\Enums\ResponseType;

test('update profile info', function () {
    $this->actingAs($this->user)
        ->patchJson(route('profile.update'), [
            'name' => 'Test User',
            'email' => 'test@test.app',
        ])
        ->assertSuccessful()
        ->assertJson(['type' => ResponseType::Success->value]);

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'Test User',
        'email' => 'test@test.app',
    ]);
});
