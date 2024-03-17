<?php

use App\Modules\Core\Controllers\Controller;

test('update profile info', function () {
    $this->actingAs($this->user)
        ->patchJson(route('profile.update'), [
            'name' => 'Test User',
            'email' => 'test@test.app',
        ])
        ->assertSuccessful()
        ->assertJson(['type' => Controller::RESPONSE_TYPE_SUCCESS]);

    $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => 'Test User',
        'email' => 'test@test.app',
    ]);
});
