<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// 

Route::get('/' , [UserController::class, 'Index'])->name('index');
Route::get('/dashboard' ,function () {
    return View('frontend.dashboard.dashboard');
});
