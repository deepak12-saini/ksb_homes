<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KsbSelectController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/our-story', function () {
    return view('our-story');
});

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/ksb-select', [KsbSelectController::class, 'create'])->name('ksb-select.index');
Route::post('/ksb-select', [KsbSelectController::class, 'storeStep1'])->name('ksb-select.step1');
Route::get('/ksb-select/your-project', [KsbSelectController::class, 'step2'])->name('ksb-select.step2');
Route::post('/ksb-select/your-project', [KsbSelectController::class, 'store'])->name('ksb-select.submit');

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
