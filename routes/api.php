<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Default Login
Route::get('/login', function(){
    return 'Unauthenticated, check your emai to verify your account';
})->name('login');

// Restrinct route
Route::get('/restrinct', function() {
    return 'Bem vindo ao sistema!';
})->name('restrinct')->middleware(['auth:api', 'verified']);


// Verify user e-mail
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
// Resent user verification email
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// User Resource
Route::namespace('Api')->group(function(){
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
});
