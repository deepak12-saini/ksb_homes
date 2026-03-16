<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/our-story', function () {
    return view('our-story');
});

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/contact', function () {
    return view('contact');
});

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// Admin (password in .env ADMIN_PASSWORD, default 'admin')
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::resource('projects', AdminProjectController::class)->except(['show']);
});
