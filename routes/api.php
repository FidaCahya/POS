<?php

use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', App\http\Controllers\Api\RegisterController:: class)->name('register');
Route::post('/login', App\http\Controllers\Api\LoginController:: class)->name('login');
Route::post('/logout', App\http\Controllers\Api\LogoutController:: class)->name('logout');

Route::middleware('auth:api')->get('/user', function (Request $request) {
     return $request->user();
});
