<?php

use App\Http\Controllers\Authenticate\ForgotPasswordController;
use App\Http\Controllers\Authenticate\LoginController;
use App\Http\Controllers\Authenticate\RegisterController;
use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('auth.login');
// });

// Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/login',[LoginController::class,'login'])->name('login');

// ForgotPasswordController
Route::get('/forgot-password',[ForgotPasswordController::class,'showForgotPasswordForm'])->name('password.request'); 
Route::post('forgot-password',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}',[ForgotPasswordController::class,'showResetPasswordForm'])->name('resetPassword');
Route::post('/reset-password',[ForgotPasswordController::class,'resetPassword'])->name('password.update');

// RegisterController
Route::get('/register',[RegisterController::class,'showRegisterForm'])->name('user.register'); 
Route::post('/register',[RegisterController::class,'registerUser'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard',DashboardController::class);
    Route::post('/logout',[LoginController::class,'logout'])->name('logout');
});