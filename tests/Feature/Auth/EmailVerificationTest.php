<?php

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

beforeEach(function () {
    $this->user = User::factory()->create(['email_verified_at' => null]);
});

test('can verify email', function () {
    $user = User::factory()->create(['email_verified_at' => null]);
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['user' => $user->id]);

    Event::fake();

    $this->actingAs($this->user)
        ->postJson($url)
        ->assertSuccessful()
        ->assertJsonFragment(['status' => 'Your email has been verified!']);

    Event::assertDispatched(Verified::class, function (Verified $e) use ($user) {
        return $e->user->is($user);
    });
});

test('can not verify if already verified', function () {
    $user = User::factory()->create();
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['user' => $user->id]);

    $this->actingAs($this->user)
        ->postJson($url)
        ->assertStatus(400)
        ->assertJsonFragment(['status' => 'The email is already verified.']);
});

test('can not verify if url has invalid_signature', function () {
    $user = User::factory()->create(['email_verified_at' => null]);

    $this->actingAs($this->user)
        ->postJson(route('verification.verify', ['user' => $user]))
        ->assertStatus(400)
        ->assertJsonFragment(['status' => 'The verification link is invalid.']);
});

test('resend verification notification', function () {
    $user = User::factory()->create(['email_verified_at' => null]);

    Notification::fake();

    $this->actingAs($this->user)
        ->postJson(route('verification.resend', ['email' => $user->email]))
        ->assertSuccessful();

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('can not resend verification notification if email does not exist', function () {
    $this->actingAs($this->user)
        ->postJson(route('verification.resend', ['email' => 'not_existed_email@app.com']))
        ->assertStatus(422)
        ->assertJsonFragment(['errors' => ['email' => ['We can\'t find a user with that e-mail address.']]]);
});

test('can not resend verification notification if email already verified', function () {
    $user = User::factory()->create();

    Notification::fake();

    $this->actingAs($this->user)
        ->postJson(route('verification.resend', ['email' => $user->email]))
        ->assertStatus(422)
        ->assertJsonFragment(['errors' => ['email' => ['The email is already verified.']]]);

    Notification::assertNotSentTo($user, VerifyEmail::class);
});
