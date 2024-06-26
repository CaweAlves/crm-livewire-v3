<?php

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Login::class)
        ->assertOk();
});

it('should be able to login', function () {
    $user = User::factory()->create([
        'email'    => 'c@w.com',
        'password' => '1',
    ]);

    Livewire::test(Login::class)
        ->set('email', 'c@w.com')
        ->set('password', '1')
        ->call('tryToLogin')
        ->assertHasNoErrors()
        ->assertRedirect('home');

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);

});

it('should make sure to inform the user an error when email and password doesnt work', function () {
    Livewire::test(Login::class)
        ->set('email', 'c@w.com')
        ->set('password', '1')
        ->call('tryToLogin')
        ->assertHasErrors(['invalidCredentials'])
        ->assertSee(trans('auth.failed'))
        ->assertNoRedirect('home');

});

it('should make sure that the rate limiting is blocking after 5 attempts', function () {
    $user = User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('tryToLogin')
            ->assertHasErrors('invalidCredentials');
    }

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('tryToLogin')
        ->assertHasErrors('rateLimiter');
});
