<?php

use App\Models\User;

test('users can authenticate', function () {
    $response = $this->postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'password',
        'device_name' => 'spa',
    ]);

    $token = $response->json()['token'];

    $response
        ->assertSuccessful()
        ->assertJson(['token' => $token])
        ->assertHeader('Authorization');

    $this->withToken($token)
        ->postJson(route('me'))
        ->assertSuccessful();

    $this->assertDatabaseHas('personal_access_tokens', [
        'name' => 'spa',
        'tokenable_id' => $this->user->id,
        'tokenable_type' => User::class,
    ]);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('fetch the current user', function () {
    $this->actingAs($this->user)
        ->postJson(route('me'))
        ->assertSuccessful()
        ->assertJsonPath('data.email', $this->user->email);
});

test('users can logout', function () {

    $response = $this->postJson(route('login'), [
        'email' => $this->user->email,
        'password' => 'password',
        'device_name' => 'spa',
    ]);

    $token = $response->json()['token'];

    $this->withToken($token)
        ->postJson(route('logout'))
        ->assertNoContent();

    $this->assertDatabaseMissing('personal_access_tokens', [
        'name' => 'spa',
        'tokenable_id' => $this->user->id,
        'tokenable_type' => User::class,
    ]);

    $this->withToken($token)
        ->postJson(route('me'))
        ->assertStatus(401);
});
