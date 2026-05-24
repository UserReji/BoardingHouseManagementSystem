<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return redirect()->route(auth()->user()->role === UserRole::Manager ? 'manager.dashboard' : 'tenant.dashboard');
});

require __DIR__.'/auth.php';
require __DIR__.'/manager.php';
require __DIR__.'/tenant.php';
