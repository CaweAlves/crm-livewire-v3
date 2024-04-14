<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\{Auth, Route};

Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', fn () => Auth::logout())->name('logout');
Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Welcome::class);
    Route::get('/home', Welcome::class)->name('home');
});
