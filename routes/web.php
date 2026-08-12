<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Home route after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Add LOP routes
    Route::get('/lop/add', [App\Http\Controllers\LopController::class, 'create'])->name('lop.create');
    Route::post('/lop/store', [App\Http\Controllers\LopController::class, 'store'])->name('lop.store');
});

// Update your existing witel routes
Route::middleware(['auth'])->group(function () {
    // Witel routes
    Route::get('/witel/search', [App\Http\Controllers\WitelController::class, 'search'])->name('witel.search');
    Route::get('/witel/{id}', [App\Http\Controllers\WitelController::class, 'show'])->name('witel.show');
    Route::get('/site/{lopId}', [App\Http\Controllers\WitelController::class, 'siteDetail'])->name('witel.site-detail');
});

// Add these routes to your existing web.php file
Route::middleware(['auth'])->group(function () {
    // Form routes
    Route::get('/forms', [App\Http\Controllers\FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/upload/{type}', [App\Http\Controllers\FormController::class, 'uploadForm'])->name('forms.upload');
    Route::post('/forms/upload/{type}', [App\Http\Controllers\FormController::class, 'processUpload'])->name('forms.process-upload');
    Route::get('/forms/list', [App\Http\Controllers\FormController::class, 'list'])->name('forms.list');
    Route::get('/forms/download/{id}', [App\Http\Controllers\FormController::class, 'download'])->name('forms.download');
});

// Add or modify routes in web.php
// Add these routes to your web.php file
Route::middleware(['auth'])->group(function () {
    // Forms routes
    Route::get('/forms', [App\Http\Controllers\FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/upload/{type}/{id?}', [App\Http\Controllers\FormController::class, 'uploadForm'])->name('forms.upload');
    Route::post('/forms/upload/{type}', [App\Http\Controllers\FormController::class, 'processUpload'])->name('forms.process-upload');
    Route::get('/forms/list', [App\Http\Controllers\FormController::class, 'list'])->name('forms.list');
    Route::get('/forms/download/{id}', [App\Http\Controllers\FormController::class, 'download'])->name('forms.download');
    Route::get('/forms/view/{id}', [App\Http\Controllers\FormController::class, 'view'])->name('forms.view');
    
    // Mini OLT form specific routes
    Route::post('/forms/mini-olt', [App\Http\Controllers\FormController::class, 'processMiniOltForm'])->name('forms.process-mini-olt');
    Route::post('/signature/upload', [App\Http\Controllers\FormController::class, 'uploadSignature'])->name('signature.upload');

    // Update or add these routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/get-date-events', [App\Http\Controllers\HomeController::class, 'getDateEvents'])->name('get-date-events');
// Add this route to your existing web routes
Route::post('/search-events', [App\Http\Controllers\HomeController::class, 'searchEvents'])->name('search-events');

// Add these routes to your existing routes file
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
// Add this route to your web.php file
Route::put('/lop/{lop}', [App\Http\Controllers\LopController::class, 'update'])->name('lop.update');

// Dashboard routes
Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('home');

// Pastikan route ini berada dalam group middleware 'web'
Route::post('/dashboard/filter', [App\Http\Controllers\DashboardController::class, 'filter'])
    ->name('dashboard.filter')
    ->middleware('web');
});