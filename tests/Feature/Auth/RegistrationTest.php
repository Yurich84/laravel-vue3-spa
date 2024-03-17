<?php

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

test('new user can register', function () {
    $response = $this->postJson(route('register'), [
        User::COLUMN_NAME => 'Test User',
        User::COLUMN_EMAIL => 'test@test.app',
        User::COLUMN_PASSWORD => 'Pa$$w0rd',
        'password_confirmation' => 'Pa$$w0rd',
    ])
        ->assertSuccessful();

    if (new User instanceof MustVerifyEmail) {
        $response->assertJson(['status' => 'We have e-mailed your verification link!']);
    } else {
        $response->assertJsonStructure(['id', 'name', 'email']);
    }

    $this->assertDatabaseHas('users', [
        User::COLUMN_NAME => 'Test User',
        User::COLUMN_EMAIL => 'test@test.app',
    ]);
});

test('new user cannot register with existing email', function () {
    User::factory()->create(['email' => 'test@test.app']);

    $this->postJson(route('register'), [
        'name' => 'Test User',
        'email' => 'test@test.app',
        'password' => 'secret',
        'password_confirmation' => 'secret',
    ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
