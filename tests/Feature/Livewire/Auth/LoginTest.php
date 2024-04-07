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
