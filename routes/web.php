<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix("auth")->group(function() {
    Route::get("", function() {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'HalamanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('post.login');
});


